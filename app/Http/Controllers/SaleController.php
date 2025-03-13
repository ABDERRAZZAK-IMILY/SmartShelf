<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\UpdateStockJob;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Sales",
 *     description="Sales management operations"
 * )
 */
class SaleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sales",
     *     summary="Get all sales",
     *     description="Retrieve a list of all sales, including associated product and user information",
     *     tags={"Sales"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="product_id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="quantity", type="integer", example=2),
     *                 @OA\Property(property="total_price", type="number", example=5.98),
     *                 @OA\Property(
     *                     property="product",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Milk"),
     *                     @OA\Property(property="category", type="string", example="Dairy"),
     *                     @OA\Property(property="price", type="number", example=2.99),
     *                     @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *                     @OA\Property(property="is_on_sale", type="boolean", example=false)
     *                 ),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="ABDERRAZZAK IMILY"),
     *                     @OA\Property(property="email", type="string", example="IMILY@example.com")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $sales = Sale::with(['product', 'user'])->get();
        return response()->json($sales);
    }

    /**
     * @OA\Post(
     *     path="/api/sales",
     *     summary="Create a new sale",
     *     description="Record a new sale for a product, updating stock via a queued job",
     *     tags={"Sales"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id", "quantity"},
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sale created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2),
     *             @OA\Property(property="total_price", type="number", example=5.98)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Insufficient stock",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Insufficient stock")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The product_id field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
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

    /**
     * @OA\Get(
     *     path="/api/sales/{id}",
     *     summary="Get a specific sale",
     *     description="Retrieve a specific sale by its ID, including associated product and user information",
     *     tags={"Sales"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Sale ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2),
     *             @OA\Property(property="total_price", type="number", example=5.98),
     *             @OA\Property(
     *                 property="product",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Milk"),
     *                 @OA\Property(property="category", type="string", example="Dairy"),
     *                 @OA\Property(property="price", type="number", example=2.99),
     *                 @OA\Property(property="sale_price", type="number", example=1.99, nullable=true),
     *                 @OA\Property(property="is_on_sale", type="boolean", example=false)
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ABDERRAZZAK IMILY"),
     *                 @OA\Property(property="email", type="string", example="IMILY@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sale not found")
     *         )
     *     )
     * )
     */
    public function show(Sale $sale)
    {
        return response()->json($sale->load(['product', 'user']));
    }
}