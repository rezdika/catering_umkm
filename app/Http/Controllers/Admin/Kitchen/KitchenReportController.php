<?php

namespace App\Http\Controllers\Admin\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KitchenReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $orders = Order::with(['orderItems.menu', 'user'])
                      ->whereBetween('delivery_date', [$startDate, $endDate])
                      ->where('payment_status', 'verified')
                      ->whereIn('status', ['payment_verified', 'preparing', 'ready', 'on_delivery', 'delivered'])
                      ->get();

        $stats = [
            'total_orders' => $orders->count(),
            'total_portions' => $orders->sum(function($order) {
                return $order->orderItems->sum('quantity');
            }),
            'by_status' => [
                'payment_verified' => $orders->where('status', 'payment_verified')->count(),
                'preparing' => $orders->where('status', 'preparing')->count(),
                'ready' => $orders->where('status', 'ready')->count(),
                'on_delivery' => $orders->where('status', 'on_delivery')->count(),
                'delivered' => $orders->where('status', 'delivered')->count(),
            ],
            'popular_menus' => $orders->flatMap->orderItems
                                    ->groupBy('menu.name')
                                    ->map(function($items) {
                                        return $items->sum('quantity');
                                    })
                                    ->sortDesc()
                                    ->take(5)
        ];

        return view('admin.kitchen.pages.reports.index', compact('orders', 'stats', 'startDate', 'endDate'));
    }
}