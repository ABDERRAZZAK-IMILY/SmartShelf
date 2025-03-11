<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('rayon')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rayon_id' => 'required|exists:rayons,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'stock_threshold' => 'required|integer',
            'is_popular' => 'boolean',
            'is_on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric',
        ]);

        $product = Product::create([
            'rayon_id' => $request->rayon_id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'stock_threshold' => $request->stock_threshold,
            'is_popular' => $request->is_popular ?? false,
            'is_on_sale' => $request->is_on_sale ?? false,
            'sale_price' => $request->sale_price,
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('rayon'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'rayon_id' => 'required|exists:rayons,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'stock_threshold' => 'required|integer',
            'is_popular' => 'boolean',
            'is_on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric',
        ]);

        $product->update([
            'rayon_id' => $request->rayon_id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'stock_threshold' => $request->stock_threshold,
            'is_popular' => $request->is_popular ?? false,
            'is_on_sale' => $request->is_on_sale ?? false,
            'sale_price' => $request->sale_price,
        ]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('rayon_id')) {
            $query->where('rayon_id', $request->rayon_id);
        }

        $products = $query->with('rayon')->get();
        return response()->json($products);
    }

    public function popularOrOnSale(Request $request)
    {
        $query = Product::query();

        if ($request->query('popular')) {
            $query->where('is_popular', true);
        }

        if ($request->query('on_sale')) {
            $query->where('is_on_sale', true);
        }

        $products = $query->with('rayon')->get();
        return response()->json($products);
    }
}