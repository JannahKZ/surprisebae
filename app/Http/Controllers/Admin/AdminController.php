<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<', 5)->count();
        $outOfStock = Product::where('stock', 0)->count();

        $orders = Order::latest()->take(10)->get(); 

        return view('dashboard', compact('ordersToday', 'lowStock', 'outOfStock', 'orders'));
    }

    
}
