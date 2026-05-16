<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total');
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        $orderStats = [
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        $weeklySales = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'label'   => $date->locale('id')->isoFormat('ddd D/M'),
                'revenue' => Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date->toDateString())
                    ->sum('total'),
                'orders'  => Order::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue', 'totalCustomers',
            'recentOrders', 'topProducts', 'orderStats', 'weeklySales'
        ));
    }
}
