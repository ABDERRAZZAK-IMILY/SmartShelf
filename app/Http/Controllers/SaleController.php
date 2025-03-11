<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\UpdateStockJob;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['product', 'user'])->get();
        return response()->json($sales);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $totalPrice = $product->is_on_sale ? $product->sale_price * $request->quantity : $product->price * $request->quantity;

        $sale = Sale::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        UpdateStockJob::dispatch($product, $request->quantity);

        return response()->json($sale, 201);
    }

    public function show(Sale $sale)
    {
        return response()->json($sale->load(['product', 'user']));
    }
}