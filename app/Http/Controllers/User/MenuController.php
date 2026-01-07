<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount('menus')->get();
        $menus = Menu::with('category')->where('is_active', true)->get();
        
        return view('user.pages.menu', compact('categories', 'menus'));
    }
    
    public function show(Menu $menu)
    {
        if (!$menu->is_active) {
            abort(404);
        }
        
        // Get related products from same category
        $relatedMenus = Menu::with('category')
                           ->where('category_id', $menu->category_id)
                           ->where('id', '!=', $menu->id)
                           ->where('is_active', true)
                           ->limit(4)
                           ->get();
        
        return view('user.pages.menu-detail', compact('menu', 'relatedMenus'));
    }
}