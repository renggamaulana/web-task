<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();

        return response()->json([
            'error' => false,
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'error' => false,
            'message' => 'Data jenis barang berhasil disimpan',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if(empty($category)) {
            return response()->json([
                'error' => true,
                'message' => 'Data jenis barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'error' => false,
            'message' => 'Data jenis barang berhasil diambil',
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if(empty($category)) {
            return response()->json([
                'error' => true,
                'message' => 'Data jenis barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        $category->update($request->validated());

        return response()->json([
            'error' => false,
            'message' => 'Data jenis barang berhasil diubah',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(empty($category)) {
            return response()->json([
                'error' => true,
                'message' => 'Data jenis barang tidak ditemukan',
                'data' => null
            ], 404);
        }
        $category->products()->forceDelete();
        $category->delete();

        return response()->json([
            'error' => false,
            'message' => 'Data jenis barang berhasil dihapus',
        ]);
    }
}
