<?php

namespace App\Http\Controllers\Admin\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KurirDashboardController extends Controller
{
    public function index()
    {
        // Today's orders ready for delivery
        $todayOrders = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                           ->whereDate('delivery_date', today())
                           ->whereIn('status', ['ready', 'on_delivery'])
                           ->where('payment_status', 'verified')
                           ->orderBy('delivery_time')
                           ->get();

        // Statistics
        $totalTodayOrders = $todayOrders->count();
        $readyOrders = $todayOrders->where('status', 'ready')->count();
        $onDeliveryOrders = $todayOrders->where('status', 'on_delivery')->count();
        $deliveredToday = Order::whereDate('delivery_date', today())
                              ->where('status', 'completed')
                              ->count();

        // My assigned orders (if kurir is assigned)
        $myOrders = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                        ->where('assigned_kurir_id', auth()->id())
                        ->whereIn('status', ['ready', 'on_delivery'])
                        ->orderBy('delivery_time')
                        ->get();

        // Delivery areas summary
        $areasSummary = collect();
        if ($totalTodayOrders > 0) {
            $areasSummary = DB::table('orders')
                ->join('delivery_areas', 'orders.delivery_area_id', '=', 'delivery_areas.id')
                ->whereDate('orders.delivery_date', today())
                ->whereIn('orders.status', ['ready', 'on_delivery'])
                ->where('orders.payment_status', 'verified')
                ->select('delivery_areas.area_name', DB::raw('COUNT(*) as total_orders'))
                ->groupBy('delivery_areas.id', 'delivery_areas.area_name')
                ->orderBy('total_orders', 'desc')
                ->get();
        }

        return view('admin.kurir.dashboard', compact(
            'todayOrders', 'totalTodayOrders', 'readyOrders', 'onDeliveryOrders', 
            'deliveredToday', 'myOrders', 'areasSummary'
        ));
    }
}