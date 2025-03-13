<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Product management operations"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get all products",
     *     description="Retrieve a list of all products in the supermarket, including their associated rayon",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="rayon_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Milk"),
     *                 @OA\Property(property="category", type="string", example="Dairy"),
     *                 @OA\Property(property="price", type="number", example=2.99),
     *                 @OA\Property(property="stock", type="integer", example=100),
     *                 @OA\Property(property="stock_threshold", type="integer", example=10),
     *                 @OA\Property(property="is_popular", type="boolean", example=false),
     *                 @OA\Property(property="is_on_sale", type="boolean", example=false),
     *                 @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *                 @OA\Property(
     *                     property="rayon",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Dairy Section")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $products = Product::with('rayon')->get();
        return response()->json($products);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     description="Add a new product to the supermarket",
     *     tags={"Products"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rayon_id", "name", "category", "price", "stock", "stock_threshold"},
     *             @OA\Property(property="rayon_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Milk"),
     *             @OA\Property(property="category", type="string", example="Dairy"),
     *             @OA\Property(property="price", type="number", example=2.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="stock_threshold", type="integer", example=10),
     *             @OA\Property(property="is_popular", type="boolean", example=false),
     *             @OA\Property(property="is_on_sale", type="boolean", example=false),
     *             @OA\Property(property="sale_price", type="number", example=1.99, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="rayon_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Milk"),
     *             @OA\Property(property="category", type="string", example="Dairy"),
     *             @OA\Property(property="price", type="number", example=2.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="stock_threshold", type="integer", example=10),
     *             @OA\Property(property="is_popular", type="boolean", example=false),
     *             @OA\Property(property="is_on_sale", type="boolean", example=false),
     *             @OA\Property(property="sale_price", type="number", example=1.99, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a specific product",
     *     description="Retrieve a specific product by its ID, including its associated rayon",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="rayon_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Milk"),
     *             @OA\Property(property="category", type="string", example="Dairy"),
     *             @OA\Property(property="price", type="number", example=2.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="stock_threshold", type="integer", example=10),
     *             @OA\Property(property="is_popular", type="boolean", example=false),
     *             @OA\Property(property="is_on_sale", type="boolean", example=false),
     *             @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *             @OA\Property(
     *                 property="rayon",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Dairy Section")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function show(Product $product)
    {
        return response()->json($product->load('rayon'));
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a product",
     *     description="Update an existing product by its ID",
     *     tags={"Products"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rayon_id", "name", "category", "price", "stock", "stock_threshold"},
     *             @OA\Property(property="rayon_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Milk"),
     *             @OA\Property(property="category", type="string", example="Dairy"),
     *             @OA\Property(property="price", type="number", example=2.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="stock_threshold", type="integer", example=10),
     *             @OA\Property(property="is_popular", type="boolean", example=false),
     *             @OA\Property(property="is_on_sale", type="boolean", example=false),
     *             @OA\Property(property="sale_price", type="number", example=1.99, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="rayon_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Milk"),
     *             @OA\Property(property="category", type="string", example="Dairy"),
     *             @OA\Property(property="price", type="number", example=2.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="stock_threshold", type="integer", example=10),
     *             @OA\Property(property="is_popular", type="boolean", example=false),
     *             @OA\Property(property="is_on_sale", type="boolean", example=false),
     *             @OA\Property(property="sale_price", type="number", example=1.99, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product",
     *     description="Delete a specific product by its ID",
     *     tags={"Products"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/products/search",
     *     summary="Search products",
     *     description="Search products by name, category, or rayon_id",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Search by product name (partial match)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by product category",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="rayon_id",
     *         in="query",
     *         description="Filter by rayon ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="rayon_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Milk"),
     *                 @OA\Property(property="category", type="string", example="Dairy"),
     *                 @OA\Property(property="price", type="number", example=2.99),
     *                 @OA\Property(property="stock", type="integer", example=100),
     *                 @OA\Property(property="stock_threshold", type="integer", example=10),
     *                 @OA\Property(property="is_popular", type="boolean", example=false),
     *                 @OA\Property(property="is_on_sale", type="boolean", example=false),
     *                 @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *                 @OA\Property(
     *                     property="rayon",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Dairy Section")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/products/popular-or-on-sale",
     *     summary="Get popular or on-sale products",
     *     description="Retrieve products that are popular, on sale, or both",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="popular",
     *         in="query",
     *         description="Filter by popular products (true/false)",
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="on_sale",
     *         in="query",
     *         description="Filter by on-sale products (true/false)",
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="rayon_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Milk"),
     *                 @OA\Property(property="category", type="string", example="Dairy"),
     *                 @OA\Property(property="price", type="number", example=2.99),
     *                 @OA\Property(property="stock", type="integer", example=100),
     *                 @OA\Property(property="stock_threshold", type="integer", example=10),
     *                 @OA\Property(property="is_popular", type="boolean", example=false),
     *                 @OA\Property(property="is_on_sale", type="boolean", example=false),
     *                 @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *                 @OA\Property(
     *                     property="rayon",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Dairy Section")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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