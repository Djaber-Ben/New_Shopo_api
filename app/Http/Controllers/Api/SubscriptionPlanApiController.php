<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\StoreSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminNewSubscriptionNotification;

class SubscriptionPlanApiController extends Controller
{
    /**
     * Display all active subscription plans (API).
     */
    public function index()
    {
        $user = Auth::user();

        // Get the vendor's store
        $store = $user->store ?? null;
 
        if (!$store) {
            return response()->json([
                'message' => 'You must have a store to view subscription plans.'
            ], 403);
        }

        // Start with all active plans
        $plansQuery = SubscriptionPlan::where('status', 'active');

        // if ($store) {
        //     // Get all trial plans that this store already used
        //     $usedTrialPlanIds = StoreSubscription::where('store_id', $store->id)
        //         ->whereHas('subscriptionPlan', function ($query) {
        //             $query->where('is_trial', true);
        //         })
        //         ->pluck('subscription_plan_id')
        //         ->toArray();

        //     // Exclude them from available plans
        //     if (!empty($usedTrialPlanIds)) {
        //         $plansQuery->whereNotIn('id', $usedTrialPlanIds);
        //     }
        // }

        $hasUsedTrial = StoreSubscription::where('store_id', $store->id)
            ->whereHas('subscriptionPlan', fn($q) => $q->where('is_trial', true))
            ->exists();

        // If used a trial, hide all trial plans
        if ($hasUsedTrial) {
            $plansQuery->where('is_trial', false);
        }

        // Load plans
        $plans = $plansQuery->get();

        return response()->json([
            'plans' => $plans
        ], 200);
    }

    /**
     * Display a specific subscription plan
     */
    public function show(SubscriptionPlan $subscription_plan)
    {
        return response()->json([
            'plan' => $subscription_plan
        ], 200);
    }

    /**
     * Subscribe to a plan
     */
    public function subscribe(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        if ($user->user_type !== 'vendor') {
            return response()->json(['message' => 'Only vendors can subscribe to plans.'], 403);
        }

        $store = $user->store ?? null;
        if (!$store) {
            return response()->json(['message' => 'You must have a store to subscribe.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            // store subscription
            'payment_receipt_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:10240',
                function ($attribute, $value, $fail) use ($request) {
                    $plan = SubscriptionPlan::find($request->subscription_plan_id);
                    if ($plan && !$plan->is_trial && !$request->hasFile('payment_receipt_image')) {
                        $fail('The payment receipt image is required for non-trial plans.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan = SubscriptionPlan::where('status', 'active')->findOrFail($request->subscription_plan_id);

        // Optional: Prevent duplicate pending subscriptions
        $existing = StoreSubscription::where('store_id', $store->id)
            ->whereIn('status', ['pending'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'You already have a pending subscription for this store.',
            ], 409);
        }

        // recive and Upload the offline payment receipt image from the store owners
        // ✅ Compress receipt image using built-in PHP GD
        $payment_receipt_image = $this->compressAndStoreImage(
            $request->file('payment_receipt_image')->getRealPath(),
            'images/storeSubscriptions/payment_receipt_image'
        );

        $subscription = StoreSubscription::create([
            'store_id' => $store->id,
            'subscription_plan_id' => $plan->id,
            'payment_receipt_image' => $payment_receipt_image,
            'status' => 'pending',
        ]);

        // Send email to admin
        $admin = User::where('user_type', 'admin')->first();
        if ($admin) {
            Mail::to($admin->email)->send(new AdminNewSubscriptionNotification($store, $subscription));
        }

        return response()->json([
            'message' => 'Subscription created successfully. Awaiting admin approval.',
            'subscription' => $subscription,
        ], 201);
    }

    /**
     * ✅ Native PHP GD image compression (no Intervention needed)
     */
    private function compressAndStoreImage($uploadedFile, $folderPath)
    {
        $filename = time() . '_' . uniqid() . '.jpg';
        $destinationPath = storage_path('app/public/' . $folderPath . '/' . $filename);

        if (!file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0755, true);
        }

        $imageInfo = getimagesize($uploadedFile);
        $mime = $imageInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($uploadedFile);
                break;
            case 'image/png':
                $png = imagecreatefrompng($uploadedFile);
                $image = imagecreatetruecolor(imagesx($png), imagesy($png));
                $white = imagecolorallocate($image, 255, 255, 255);
                imagefill($image, 0, 0, $white);
                imagecopy($image, $png, 0, 0, 0, 0, imagesx($png), imagesy($png));
                break;
            default:
                return null;
        }

        // Compress at ~75% quality
        imagejpeg($image, $destinationPath, 75);

        return $folderPath . '/' . $filename;
    }
}
