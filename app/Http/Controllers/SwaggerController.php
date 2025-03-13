<?php

namespace App\Http\Controllers;

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

class SwaggerController
{
    //
}
