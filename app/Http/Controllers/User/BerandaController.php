<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil menu populer berdasarkan jumlah penjualan
        $popularMenus = Menu::popular(6)->get();

        // Jika tidak ada menu yang terjual atau jumlah menu kurang dari 3, tambahkan menu terbaru
        if ($popularMenus->count() < 3 || $popularMenus->every(fn($menu) => ($menu->total_sold ?? 0) == 0)) {
            $excludeIds = $popularMenus->pluck('id')->toArray();
            $additionalMenus = Menu::active()
                ->inStock()
                ->when(!empty($excludeIds), function($query) use ($excludeIds) {
                    return $query->whereNotIn('id', $excludeIds);
                })
                ->latest()
                ->limit(6 - $popularMenus->count())
                ->get();
            
            $popularMenus = $popularMenus->merge($additionalMenus);
        }

        return view('user.pages.beranda', compact('popularMenus'));
    }
}