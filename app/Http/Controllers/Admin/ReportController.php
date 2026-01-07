<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $monthlyRevenue = Order::where('payment_status', 'paid')
                              ->whereMonth('created_at', now()->month)
                              ->sum('total_amount');
        $totalOrders = Order::count();
        $popularMenus = Menu::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();

        return view('admin.pages.reports.index', compact(
            'totalRevenue',
            'monthlyRevenue', 
            'totalOrders',
            'popularMenus'
        ));
    }
}