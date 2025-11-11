<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    /**
     * Display all subscription plans (web).
     */
    public function index()
    {
        $plans = SubscriptionPlan::withCount('storeSubscriptions')->get();
        return view('admin.subscription_plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan (web).
     */
    public function create()
    {
        return view('admin.subscription_plans.create');
    }

    /**
     * Store a newly created plan (web).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subscription_plans,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.00',
            'compare_price' => [
                'nullable',
                'numeric',
                'min:0.00',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value !== null && $value <= $request->price) {
                        $fail('السعر السابق يجب أن يكون أكبر من السعر الحالي.');
                    }
                },
            ],
            // 'duration' => 'required|in:daily,monthly,yearly',
            'duration_days' => 'required|integer|min:1',
            'is_trial' => 'boolean',
            'status' => 'required|in:active,inactive',
        ], [
            'name.unique' => 'A plan with this name already exists.',
            // 'duration.in' => 'Duration must be one of: daily, monthly, yearly.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SubscriptionPlan::create($request->all());

        return redirect()->route('subscription-plans.index')
                         ->with('success', 'تم إنشاء خطة الاشتراك بنجاح.');
    }

    /**
     * Show the form for editing a plan (web).
     */
    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.subscription_plans.edit', compact('plan'));
    }

    /**
     * Update a plan (web).
     */
    public function update(Request $request, SubscriptionPlan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:subscription_plans,name,' . $plan->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.00',
            'compare_price' => [
                'nullable',
                'numeric',
                'min:0.00',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value !== null && $value <= $request->price) {
                        $fail('السعر السابق يجب أن يكون أكبر من السعر الحالي.');
                    }
                },
            ],
            // 'duration' => 'required|in:daily,monthly,quarterly,yearly',
            'duration_days' => 'required|integer|min:1',
            'is_trial' => 'boolean',
            'status' => 'required|in:active,inactive',
        ], [
            'name.unique' => 'A plan with this name already exists.',
            // 'duration.in' => 'Duration must be one of: daily, monthly, yearly.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plan->update($request->all());

        return redirect()->route('subscription-plans.index')
                         ->with('success', 'تم تحديث خطة الاشتراك بنجاح.');
    }

    /**
     * Delete a plan (web).
     */
    public function destroy(SubscriptionPlan $plan)
    {
        if ($plan->storeSubscriptions()->count() > 0) {
            return redirect()->route('subscription-plans.index')
                             ->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $plan->delete();

        return redirect()->route('subscription-plans.index')
                         ->with('success', 'تم حذف خطة الاشتراك بنجاح.');
    }
}