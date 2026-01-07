<?php

namespace App\Http\Controllers\Admin\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KitchenDashboardController extends Controller
{
    public function index()
    {
        // All orders that need to be prepared (not just today)
        $allOrders = Order::with(['orderItems.menu', 'user'])
                         ->whereIn('status', ['payment_verified', 'preparing', 'ready'])
                         ->where('payment_status', 'verified')
                         ->orderBy('delivery_date')
                         ->orderBy('delivery_time')
                         ->get();

        // Today's orders specifically
        $todayOrders = $allOrders->filter(function($order) {
            return $order->delivery_date->isToday();
        });

        // Statistics
        $totalTodayOrders = $todayOrders->count();
        $preparingOrders = $todayOrders->where('status', 'preparing')->count();
        $readyOrders = $todayOrders->where('status', 'ready')->count();
        $pendingOrders = $todayOrders->where('status', 'payment_verified')->count();

        // All pending orders (not just today)
        $allPendingOrders = $allOrders->where('status', 'payment_verified')->count();
        $allPreparingOrders = $allOrders->where('status', 'preparing')->count();
        $allReadyOrders = $allOrders->where('status', 'ready')->count();

        // Menu summary for all pending orders
        $menuSummary = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereIn('orders.status', ['payment_verified', 'preparing', 'ready'])
            ->where('orders.payment_status', 'verified')
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('menus.id', 'menus.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        // Production progress
        $totalAllOrders = $allOrders->count();
        $completionRate = $totalAllOrders > 0 ? (($allPreparingOrders + $allReadyOrders) / $totalAllOrders) * 100 : 0;

        // Recent completed orders (last 5)
        $recentCompleted = Order::with(['orderItems.menu', 'user'])
                                ->where('status', 'ready')
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

        return view('admin.kitchen.dashboard', compact(
            'todayOrders', 'totalTodayOrders', 'preparingOrders', 'readyOrders', 'pendingOrders',
            'allPendingOrders', 'allPreparingOrders', 'allReadyOrders', 'totalAllOrders',
            'menuSummary', 'completionRate', 'recentCompleted'
        ));
    }
}