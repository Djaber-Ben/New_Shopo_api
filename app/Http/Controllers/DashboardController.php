<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\StoreSubscription;

class DashboardController extends Controller
{
    public function stats()
    {
        // Total users excluding admins
        $totalUsers = User::where('user_type', '!=', 'admin')->count();

        // Total users of type 'client'
        $totalClients = User::where('user_type', 'client')->count();

        // Total stores
        $totalStores = Store::count();

        // Get counts grouped by status
        $subscriptionCounts = StoreSubscription::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Subscription status counts
        // Ensure all statuses are present, even if count = 0
        $subscriptionStats  = [
            'active' => $subscriptionCounts->get('active', 0),
            'expired' => $subscriptionCounts->get('expired', 0),
            'cancelled' => $subscriptionCounts->get('cancelled', 0),
            'pending' => $subscriptionCounts->get('pending', 0),
        ];

        // Store status counts
        $storeStats = [
            'active' => Store::where('status', 'active')->count(),
            'inactive' => Store::where('status', 'inactive')->count(),
        ];

        return view('admin.dashboard', compact('totalUsers', 'totalClients', 'totalStores', 'subscriptionStats', 'storeStats'));
    }
}