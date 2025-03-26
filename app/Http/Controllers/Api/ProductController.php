<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'error' => false,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'error' => false,
            'message' => 'Data barang berhasil disimpan',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if(empty($product)) {
            return response()->json([
                'error' => true,
                'message' => 'Data barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'error' => false,
            'message' => 'Data barang berhasil diambil',
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);

        if(empty($product)) {
            return response()->json([
                'error' => true,
                'message' => 'Data barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        $product->update($request->validated());

        return response()->json([
            'error' => false,
            'message' => 'Data barang berhasil diubah',
            'data' => $product
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if(empty($product)) {
            return response()->json([
                'error' => true,
                'message' => 'Data barang tidak ditemukan',
                'data' => null
            ], 404);
        }

        $product->delete();

        return response()->json([
            'error' => false,
            'message' => 'Data barang berhasil dihapus',
        ]);
}

}