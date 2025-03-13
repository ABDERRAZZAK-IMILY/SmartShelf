<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Supermarket API",
 *     version="1.0.0",
 *     description="API for managing a supermarket with departments, products, and sales",
 *     @OA\Contact(
 *         email="admin@supermarket.com",
 *         name="Support Team"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="/api",
 *     description="Main API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="Authentication and user management operations"
 * )
 * 
 * @OA\Tag(
 *     name="Rayons",
 *     description="Supermarket department management operations"
 * )
 * 
 * @OA\Tag(
 *     name="Products",
 *     description="Product management operations"
 * )
 * 
 * @OA\Tag(
 *     name="Sales",
 *     description="Sales management operations"
 * )
 * 
 * @OA\Tag(
 *     name="Statistics",
 *     description="Sales and inventory statistics"
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "email", "password", "role"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="ABDERRAZZAK IMILY"),
 *     @OA\Property(property="email", type="string", format="email", example="IMILY@example.com"),
 *     @OA\Property(property="role", type="string", enum={"admin", "client"}, example="client"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Rayon",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Fruits and Vegetables"),
 *     @OA\Property(property="description", type="string", example="Fresh fruits and vegetables section"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Product",
 *     required={"rayon_id", "name", "category", "price", "stock", "stock_threshold"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="rayon_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Red Apple"),
 *     @OA\Property(property="category", type="string", example="Fruits"),
 *     @OA\Property(property="price", type="number", format="float", example=5.99),
 *     @OA\Property(property="stock", type="integer", example=100),
 *     @OA\Property(property="stock_threshold", type="integer", example=20),
 *     @OA\Property(property="is_popular", type="boolean", example=true),
 *     @OA\Property(property="is_on_sale", type="boolean", example=false),
 *     @OA\Property(property="sale_price", type="number", format="float", example=4.99),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="rayon",
 *         ref="#/components/schemas/Rayon"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="Sale",
 *     required={"product_id", "user_id", "quantity", "total_price"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="product_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="user_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="quantity", type="integer", example=5),
 *     @OA\Property(property="total_price", type="number", format="float", example=29.95),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="product",
 *         ref="#/components/schemas/Product"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/register",
 *     summary="Register a new user",
 *     description="Create a new user account and get authentication token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation", "role"},
 *             @OA\Property(property="name", type="string", example="ABDERRAZZAK IMILY"),
 *             @OA\Property(property="email", type="string", format="email", example="IMILY@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
 *             @OA\Property(property="role", type="string", enum={"admin", "client"}, example="client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Successfully registered",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="1|laravel_sanctum_token..."),
 *             @OA\Property(
 *                 property="user",
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/login",
 *     summary="Login",
 *     description="Login and get authentication token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="IMILY@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successfully logged in",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="1|laravel_sanctum_token..."),
 *             @OA\Property(
 *                 property="user",
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid credentials"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/logout",
 *     summary="Logout",
 *     description="Logout and invalidate current token",
 *     tags={"Authentication"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successfully logged out",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Logged out successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/rayons",
 *     summary="Get list of departments",
 *     description="Retrieve a list of all supermarket departments",
 *     tags={"Rayons"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of departments",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Rayon")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/rayons",
 *     summary="Create a new department",
 *     description="Create a new department in the supermarket (admin only)",
 *     tags={"Rayons"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Dairy Products"),
 *             @OA\Property(property="description", type="string", example="Milk and cheese products section")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Department created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Rayon")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/rayons/{id}",
 *     summary="Get department details",
 *     description="Retrieve details of a specific department by ID",
 *     tags={"Rayons"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Department ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Department details",
 *         @OA\JsonContent(ref="#/components/schemas/Rayon")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Department not found"
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/rayons/{id}",
 *     summary="Update department",
 *     description="Update an existing department (admin only)",
 *     tags={"Rayons"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Department ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Dairy Products - Updated"),
 *             @OA\Property(property="description", type="string", example="Updated milk and cheese products section")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Department updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Rayon")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Department not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/rayons/{id}",
 *     summary="Delete department",
 *     description="Delete an existing department (admin only)",
 *     tags={"Rayons"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Department ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Department deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Department not found"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/products",
 *     summary="Get list of products",
 *     description="Retrieve a list of all products",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of products",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/products",
 *     summary="Create a new product",
 *     description="Create a new product (admin only)",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"rayon_id", "name", "category", "price", "stock", "stock_threshold"},
 *             @OA\Property(property="rayon_id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Green Apple"),
 *             @OA\Property(property="category", type="string", example="Fruits"),
 *             @OA\Property(property="price", type="number", format="float", example=4.99),
 *             @OA\Property(property="stock", type="integer", example=150),
 *             @OA\Property(property="stock_threshold", type="integer", example=30),
 *             @OA\Property(property="is_popular", type="boolean", example=false),
 *             @OA\Property(property="is_on_sale", type="boolean", example=false),
 *             @OA\Property(property="sale_price", type="number", format="float", example=null)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Product created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/products/{id}",
 *     summary="Get product details",
 *     description="Retrieve details of a specific product by ID",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Product ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product details",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/products/{id}",
 *     summary="Update product",
 *     description="Update an existing product (admin only)",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Product ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"rayon_id", "name", "category", "price", "stock", "stock_threshold"},
 *             @OA\Property(property="rayon_id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Green Apple - Updated"),
 *             @OA\Property(property="category", type="string", example="Fruits"),
 *             @OA\Property(property="price", type="number", format="float", example=5.49),
 *             @OA\Property(property="stock", type="integer", example=120),
 *             @OA\Property(property="stock_threshold", type="integer", example=25),
 *             @OA\Property(property="is_popular", type="boolean", example=true),
 *             @OA\Property(property="is_on_sale", type="boolean", example=true),
 *             @OA\Property(property="sale_price", type="number", format="float", example=4.79)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/products/{id}",
 *     summary="Delete product",
 *     description="Delete an existing product (admin only)",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Product ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Product deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/products/search",
 *     summary="Search products",
 *     description="Search for products using different criteria",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         description="Product name (partial)",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="Product category",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="rayon_id",
 *         in="query",
 *         description="Department ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of matching products",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/products/popular-or-on-sale",
 *     summary="Popular or on-sale products",
 *     description="Get products that are popular or on sale",
 *     tags={"Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="popular",
 *         in="query",
 *         description="Filter popular products",
 *         required=false,
 *         @OA\Schema(type="boolean")
 *     ),
 *     @OA\Parameter(
 *         name="on_sale",
 *         in="query",
 *         description="Filter products on sale",
 *         required=false,
 *         @OA\Schema(type="boolean")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of matching products",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/sales",
 *     summary="Get list of sales",
 *     description="Retrieve a list of all sales",
 *     tags={"Sales"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of sales",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Sale")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/sales",
 *     summary="Record a new sale",
 *     description="Record a new sale and update inventory",
 *     tags={"Sales"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "quantity"},
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="quantity", type="integer", example=5)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Sale recorded successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Sale")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Insufficient stock"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid data"
 *     )
 * )
 * 
 * @OA\Get(
 *     path="/sales/{id}",
 *     summary="Get sale details",
 *     description="Retrieve details of a specific sale by ID",
 *     tags={"Sales"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Sale ID",
 *         required=true,
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sale details",
 *         @OA\JsonContent(ref="#/components/schemas/Sale")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Sale not found"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/statistics",
 *     summary="Get statistics",
 *     description="Get sales and inventory statistics",
 *     tags={"Statistics"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Statistics data",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="top_products",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="product_id", type="integer", example=1),
 *                     @OA\Property(property="total_quantity", type="integer", example=150),
 *                     @OA\Property(
 *                         property="product",
 *                         ref="#/components/schemas/Product"
 *                     )
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="low_stock_products",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Product")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
