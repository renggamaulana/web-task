<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if($categories->isEmpty()) {
            return response()->json([
                'error' => true,
                'message' => 'Jenis barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'error' => false,
            'message' => 'Data berhasil diambil',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create($request->validated());

            return response()->json([
                'error' => false,
                'message' => 'Jenis barang berhasil dibuat',
                'data' => $category
            ], 201);
       } catch(\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan',
                'details' => $e->getMessage()
            ], 500);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
