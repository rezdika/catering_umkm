<?php

namespace App\Http\Controllers\Admin\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KurirReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $kurirId = $request->get('kurir_id', auth()->id());

        $orders = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                      ->whereBetween('delivery_date', [$startDate, $endDate])
                      ->where('payment_status', 'verified')
                      ->whereIn('status', ['ready', 'on_delivery', 'delivered'])
                      ->when($kurirId, function($query, $kurirId) {
                          return $query->where('assigned_kurir_id', $kurirId);
                      })
                      ->get();

        $stats = [
            'total_deliveries' => $orders->count(),
            'completed_deliveries' => $orders->where('status', 'delivered')->count(),
            'on_delivery' => $orders->where('status', 'on_delivery')->count(),
            'ready_to_deliver' => $orders->where('status', 'ready')->count(),
            'total_areas' => $orders->pluck('deliveryArea.name')->unique()->count(),
            'popular_areas' => $orders->groupBy('deliveryArea.name')
                                    ->map(function($items) {
                                        return $items->count();
                                    })
                                    ->sortDesc()
                                    ->take(5)
        ];

        return view('admin.kurir.pages.reports.index', compact('orders', 'stats', 'startDate', 'endDate', 'kurirId'));
    }
}