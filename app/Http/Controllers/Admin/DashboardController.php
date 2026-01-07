<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics for admin dashboard (data master & monitoring)
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $activeMenus = Menu::where('is_active', true)->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalCategories = Category::where('is_active', true)->count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $totalContacts = Contact::count();
        $unreadContacts = Contact::where('status', 'new')->count();

        // Menu Analytics
        $menusByCategory = Category::withCount('menus')->get();
        $menuStockData = Menu::select('name', 'stock')->where('is_active', true)->get();
        $lowStockMenus = Menu::where('stock', '<', 10)->where('is_active', true)->count();
        
        // User Growth (last 7 days)
        $userGrowthLabels = [];
        $userGrowthData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $userGrowthLabels[] = $date->format('d/m');
            $userGrowthData[] = User::whereDate('created_at', $date)->count();
        }
        
        // Order Status Distribution
        $orderStatusData = [
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];
        
        // Contact Types Distribution
        $contactTypes = [
            'Pertanyaan Menu' => Contact::where('subject', 'like', '%menu%')->count(),
            'Pemesanan' => Contact::where('subject', 'like', '%pesan%')->count(),
            'Saran' => Contact::where('subject', 'like', '%saran%')->count(),
            'Kritik' => Contact::where('subject', 'like', '%kritik%')->count(),
            'Lainnya' => Contact::whereNotIn('subject', ['Pertanyaan Menu', 'Pemesanan Catering', 'Saran', 'Kritik'])->count()
        ];
        
        // Recent Activities
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.pages.dashboard', compact(
            'totalOrders', 'pendingOrders', 'activeMenus', 'totalUsers',
            'totalCategories', 'newUsersToday', 'totalContacts', 'unreadContacts',
            'menusByCategory', 'menuStockData', 'lowStockMenus',
            'userGrowthLabels', 'userGrowthData', 'orderStatusData', 'contactTypes',
            'recentOrders', 'recentUsers', 'recentContacts'
        ));
    }
}