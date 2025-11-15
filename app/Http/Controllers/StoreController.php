<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\StoreSubscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\StoreSubscriptionStatusUpdated;

class StoreController extends Controller
{
     public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $stores = Store::with(['latestSubscription.subscriptionPlan'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('store_name', 'like', "%{$keyword}%")
                    ->orWhere('id', $keyword)
                    ->orWhereHas('latestSubscription', function ($q) use ($keyword) {
                        $q->where('status', 'like', "%{$keyword}%")
                            ->orWhereHas('subscriptionPlan', function ($qp) use ($keyword) {
                                $qp->where('name', 'like', "%{$keyword}%");
                            });
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.store.list', compact('stores'));
    }

    public function edit($storeId, Request $request){
        $store = Store::find($storeId);
        if(empty($store)){
            return redirect()->route('stores.index');
        }
        return view('admin.store.edit', compact('store'));
    }

    public function update( Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'subscription_status' => 'required|in:active,expired,cancelled,pending',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find store
        $store = Store::findOrFail($id);

        // Update store status
        $store->status = $request->status;
        $store->save();

        // Get latest subscription (if any)
        $subscription = $store->subscriptions()->latest()->first();

        if ($subscription && $request->filled('subscription_status')) {
            $plan = $subscription->subscriptionPlan;

            // Determine new start_date
            $activeSub = $store->subscriptions()
                ->where('status', 'active')
                ->latest()
                ->first();

            if ($activeSub && $activeSub->end_date) {
                // Start after the current active subscription ends
                $newStart = Carbon::parse($activeSub->end_date);
            } else {
                // No active subscription → start now
                $newStart = now();
            }

            // Calculate new end_date
            $newEnd = $plan ? $newStart->copy()->addDays($plan->duration_days) : null;

            // Update the subscription
            $subscription->update([
                'status' => $request->subscription_status,
                'start_date' => $newStart,
                'end_date' => $newEnd,
            ]);

            // Store-level subscription expiry
            $store->update(['subscription_expires_at' => $newEnd]);

            // Send email notification to the vendor
            $vendor = $store->vendor; // relationship Store->vendor()
            if ($vendor && $vendor->email) {
                Mail::to($vendor->email)->send(new StoreSubscriptionStatusUpdated($store, $subscription, $vendor));
            }
        }

        $request->session()->flash('success', 'تم تحديث حالة المتجر والاشتراك بنجاح.');

        return redirect()->back();
    }
}