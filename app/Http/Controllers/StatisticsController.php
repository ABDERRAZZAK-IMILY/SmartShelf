<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class StatisticsController extends Controller
{
    public function index()
    {
        $topProducts = Sale::select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->with('product')
            ->get();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'stock_threshold')
            ->get();

        return response()->json([
            'top_products' => $topProducts,
            'low_stock_products' => $lowStockProducts,
        ]);
    }
}