<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Rayons",
 *     description="Supermarket department management operations"
 * )
 */
class RayonController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rayons",
     *     summary="Get all rayons",
     *     description="Retrieve a list of all departments (rayons) in the supermarket",
     *     tags={"Rayons"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Dairy Section"),
     *                 @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $rayons = Rayon::all();
        return response()->json($rayons);
    }

    /**
     * @OA\Post(
     *     path="/api/rayons",
     *     summary="Create a new rayon",
     *     description="Add a new department (rayon) to the supermarket",
     *     tags={"Rayons"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Dairy Section"),
     *             @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rayon created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Dairy Section"),
     *             @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $rayon = Rayon::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($rayon, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/rayons/{id}",
     *     summary="Get a specific rayon",
     *     description="Retrieve a specific department (rayon) by its ID",
     *     tags={"Rayons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rayon ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Dairy Section"),
     *             @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rayon not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rayon not found")
     *         )
     *     )
     * )
     */
    public function show(Rayon $rayon)
    {
        return response()->json($rayon);
    }

    /**
     * @OA\Put(
     *     path="/api/rayons/{id}",
     *     summary="Update a rayon",
     *     description="Update an existing department (rayon) by its ID",
     *     tags={"Rayons"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rayon ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Dairy Section"),
     *             @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rayon updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Dairy Section"),
     *             @OA\Property(property="description", type="string", example="Section for dairy products", nullable=true)
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
     *         description="Rayon not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rayon not found")
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
    public function update(Request $request, Rayon $rayon)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $rayon->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($rayon);
    }

    /**
     * @OA\Delete(
     *     path="/api/rayons/{id}",
     *     summary="Delete a rayon",
     *     description="Delete a specific department (rayon) by its ID",
     *     tags={"Rayons"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Rayon ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Rayon deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rayon not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rayon not found")
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
    public function destroy(Rayon $rayon)
    {
        $rayon->delete();
        return response()->json(null, 204);
    }
}