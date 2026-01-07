<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        $status = $request->get('status');

        // Base query
        $paymentsQuery = Payment::whereBetween('created_at', [$dateFrom, $dateTo]);
        $ordersQuery = Order::whereBetween('created_at', [$dateFrom, $dateTo]);

        // Apply filters
        if ($paymentMethod) {
            $paymentsQuery->where('payment_method', $paymentMethod);
        }
        if ($status) {
            $paymentsQuery->where('status', $status);
        }

        // Revenue Summary
        $totalRevenue = $paymentsQuery->clone()->where('status', 'verified')->sum('amount');
        $totalOrders = $ordersQuery->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalTransactions = $paymentsQuery->clone()->count();
        
        // Payment Method Analysis
        $paymentMethodStats = Payment::where('status', 'verified')
                                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                                    ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
                                    ->groupBy('payment_method')
                                    ->get();

        // Status Analysis
        $statusStats = Payment::whereBetween('created_at', [$dateFrom, $dateTo])
                             ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
                             ->groupBy('status')
                             ->get();

        // Daily/Monthly Revenue Chart
        $revenueChart = $this->getRevenueChart($period, $dateFrom, $dateTo);
        
        // Top Revenue Days
        $topRevenueDays = Payment::where('status', 'verified')
                                ->whereBetween('created_at', [$dateFrom, $dateTo])
                                ->selectRaw('DATE(created_at) as date, SUM(amount) as total, COUNT(*) as transactions')
                                ->groupBy('date')
                                ->orderBy('total', 'desc')
                                ->limit(10)
                                ->get();

        // Growth Analysis
        $previousPeriodStart = Carbon::parse($dateFrom)->subDays(Carbon::parse($dateTo)->diffInDays(Carbon::parse($dateFrom)));
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay();
        
        $previousRevenue = Payment::where('status', 'verified')
                                 ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
                                 ->sum('amount');
        
        $growthPercentage = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

        return view('admin.finance.pages.reports.index', compact(
            'totalRevenue', 'totalOrders', 'averageOrderValue', 'totalTransactions',
            'paymentMethodStats', 'statusStats', 'revenueChart', 'topRevenueDays',
            'period', 'dateFrom', 'dateTo', 'paymentMethod', 'status',
            'previousRevenue', 'growthPercentage'
        ));
    }

    public function export(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));
        
        $payments = Payment::with(['order.user'])
                          ->whereBetween('created_at', [$dateFrom, $dateTo])
                          ->where('status', 'verified')
                          ->orderBy('created_at', 'desc')
                          ->get();

        $filename = 'laporan-keuangan-' . $dateFrom . '-to-' . $dateTo . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Order Number', 'Customer', 'Jumlah', 'Metode Pembayaran', 'Status']);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->created_at->format('d/m/Y H:i'),
                    $payment->order->order_number,
                    $payment->order->user->name,
                    number_format($payment->amount, 0, ',', '.'),
                    ucfirst(str_replace('_', ' ', $payment->payment_method)),
                    ucfirst($payment->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getRevenueChart($period, $dateFrom, $dateTo)
    {
        $labels = [];
        $data = [];
        
        if ($period === 'daily') {
            $start = Carbon::parse($dateFrom);
            $end = Carbon::parse($dateTo);
            
            while ($start <= $end) {
                $labels[] = $start->format('d/m');
                $data[] = Payment::where('status', 'verified')
                                ->whereDate('created_at', $start)
                                ->sum('amount');
                $start->addDay();
            }
        } else {
            // Monthly
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M Y');
                $data[] = Payment::where('status', 'verified')
                                ->whereYear('created_at', $date->year)
                                ->whereMonth('created_at', $date->month)
                                ->sum('amount');
            }
        }
        
        return compact('labels', 'data');
    }
}