<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Sales Summary Report
    public function salesSummary(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $salesData = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->groupBy('month')
        ->get();

        $months = $salesData->pluck('month');
        $totals = $salesData->pluck('total');

        return view('reports.salesSummary', compact('months', 'totals', 'month', 'year'));
    }

    // Inventory Report
    public function inventory()
    {
        //$products = Product::select('name', 'category','stock')->get();
        $products = Product::with('category')->get();
        $productNames = $products->pluck('name');
        $stockLevels = $products->pluck('stock');

        return view('reports.inventory', 
        compact('products', 'productNames', 'stockLevels'));
    }

    // Sales Highlight Report
    public function salesHighlight(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Filtered items
        $items = OrderItem::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Top product (product type only)
        $topProduct = $items->where('item_type', 'product')
            ->groupBy('product_name')
            ->map(function ($group) {
                return $group->sum('quantity');
            })
            ->sortDesc()
            ->map(fn($q, $k) => ['product_name' => $k, 'total' => $q])
            ->values()
            ->first();

        // Top service (service type only)
        $topService = $items->where('item_type', 'service')
            ->groupBy('product_name')
            ->map(function ($group) {
                return $group->sum('quantity');
            })
            ->sortDesc()
            ->map(fn($q, $k) => ['product_name' => $k, 'total' => $q])
            ->values()
            ->first();

        // Top order type
        $topOrderType = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('order_type', DB::raw('COUNT(*) as total'))
            ->groupBy('order_type')
            ->orderByDesc('total')
            ->first();

        // Top payment method
        $topBuyMethod = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('payment_method', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->first();

        // Chart data: product_name vs total_sold
        $productSales = $items->where('item_type', 'product')
            ->groupBy('product_name')
            ->map(fn($g) => $g->sum('quantity'))
            ->sortDesc();

        $productNames = $productSales->keys()->values();
        $quantities = $productSales->values();

        return view('reports.salesHighlight', compact(
            'month', 'year',
            'topProduct', 'topService', 'topOrderType', 'topBuyMethod',
            'productNames', 'quantities'
        ));
    }
}
