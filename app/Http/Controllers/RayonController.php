<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    public function index()
    {
        $rayons = Rayon::all();
        return response()->json($rayons);
    }

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

    public function show(Rayon $rayon)
    {
        return response()->json($rayon);
    }

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

    public function destroy(Rayon $rayon)
    {
        $rayon->delete();
        return response()->json(null, 204);
    }
}