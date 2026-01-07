<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinanceDashboardController extends Controller
{
    public function index()
    {
        // Revenue Statistics
        $totalRevenue = Payment::where('status', 'verified')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'verified')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('amount');
        $dailyAverage = $monthlyRevenue > 0 ? $monthlyRevenue / now()->day : 0;
        
        // Payment Statistics
        $pendingPayments = Payment::where('status', 'pending')->count();
        $verifiedPayments = Payment::where('status', 'verified')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        $todayPayments = Payment::whereDate('created_at', today())->count();
        $todayRevenue = Payment::where('status', 'verified')
                              ->whereDate('created_at', today())
                              ->sum('amount');
        
        // Revenue Trend (last 7 days) - Fixed 7 days only
        $revenueTrendLabels = [];
        $revenueTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenueTrendLabels[] = $date->format('d/m');
            
            $dailyRevenue = Payment::where('status', 'verified')
                                  ->whereDate('created_at', $date)
                                  ->sum('amount');
            
            $revenueTrendData[] = (float) $dailyRevenue;
        }
        
        $revenueTrendTotal = array_sum($revenueTrendData);
        
        // Payment Methods Distribution
        $paymentMethods = [
            'bank_transfer' => Payment::where('payment_method', 'bank_transfer')->where('status', 'verified')->count(),
            'qris' => Payment::where('payment_method', 'qris')->where('status', 'verified')->count(),
            'cod' => Payment::where('payment_method', 'cod')->where('status', 'verified')->count(),
        ];
        
        // Recent Payments
        $recentPayments = Payment::with(['order.user'])
                                ->latest()
                                ->take(10)
                                ->get();
        
        // Monthly Revenue (last 6 months)
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenueLabels[] = $date->format('M Y');
            $monthlyRevenueData[] = Payment::where('status', 'verified')
                                          ->whereYear('created_at', $date->year)
                                          ->whereMonth('created_at', $date->month)
                                          ->sum('amount');
        }

        // Order Statistics
        $totalOrders = Order::count();
        $monthlyOrders = Order::whereMonth('created_at', now()->month)
                             ->whereYear('created_at', now()->year)
                             ->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // NEW: Revenue by Category (Bar Chart)
        $revenueByCategory = DB::table('payments')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->where('payments.status', 'verified')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        $categoryLabels = $revenueByCategory->pluck('category_name')->toArray();
        $categoryData = $revenueByCategory->pluck('total_revenue')->map(function($value) {
            return (float) $value;
        })->toArray();

        // NEW: Weekly Comparison (This Week vs Last Week)
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisWeekEnd = Carbon::now()->endOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        $thisWeekRevenue = Payment::where('status', 'verified')
                                 ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
                                 ->sum('amount');
        
        $lastWeekRevenue = Payment::where('status', 'verified')
                                 ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                                 ->sum('amount');

        $thisWeekOrders = Order::whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->count();
        $lastWeekOrders = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $revenueGrowth = $lastWeekRevenue > 0 ? (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100 : 0;
        $orderGrowth = $lastWeekOrders > 0 ? (($thisWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100 : 0;

        // NEW: Average Order Value Trend (7 days)
        $avgOrderLabels = [];
        $avgOrderData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $avgOrderLabels[] = $date->format('d/m');
            
            $dayOrders = Order::whereDate('created_at', $date)->count();
            $dayRevenue = Payment::where('status', 'verified')
                               ->whereDate('created_at', $date)
                               ->sum('amount');
            
            $avgValue = $dayOrders > 0 ? $dayRevenue / $dayOrders : 0;
            $avgOrderData[] = (float) $avgValue;
        }

        return view('admin.finance.dashboard', compact(
            'totalRevenue', 'monthlyRevenue', 'dailyAverage', 'todayRevenue',
            'pendingPayments', 'verifiedPayments', 'failedPayments', 'todayPayments',
            'revenueTrendLabels', 'revenueTrendData', 'revenueTrendTotal', 'paymentMethods',
            'recentPayments', 'monthlyRevenueLabels', 'monthlyRevenueData',
            'totalOrders', 'monthlyOrders', 'averageOrderValue',
            'categoryLabels', 'categoryData',
            'thisWeekRevenue', 'lastWeekRevenue', 'thisWeekOrders', 'lastWeekOrders',
            'revenueGrowth', 'orderGrowth',
            'avgOrderLabels', 'avgOrderData'
        ));
    }
}