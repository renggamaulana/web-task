<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'transaction_date'); // Default sorting by transaction_date
        $sortOrder = $request->input('order', 'desc'); // Default order asc

        $transactionLogs = TransactionLog::with(['transaction', 'product.category'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->join('products', 'transaction_logs.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_logs.transaction_id', '=', 'transactions.id')
            ->select('transaction_logs.*', 'products.name as product_name', 'transactions.transaction_date')
            ->orderBy(
                $sortField === 'name' ? 'product_name' : 'transaction_date',
                $sortOrder
            )
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'Transaction logs retrieved successfully',
            'data' => $transactionLogs
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        try {
            DB::beginTransaction();

            // Ambil data produk berdasarkan product_id
            $product = Product::findOrFail($request->product_id);

            // Pastikan stok cukup sebelum transaksi dilakukan
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'error' => true,
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            // Simpan nilai sebelum perubahan
            $previousStock = $product->stock;
            $previousSold = $product->sold;

            // Kurangi stok dan tambahkan jumlah barang yang terjual secara akumulatif
            $product->decrement('stock', $request->quantity);
            $product->update([
                'sold' => $previousSold + $request->quantity,
            ]);

            // Simpan transaksi
            $transaction = Transaction::create($request->validated());

            // Simpan ke dalam Transaction Log
            TransactionLog::create([
                'transaction_id' => $transaction->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $product->stock,
                'previous_sold' => $previousSold,
                'new_sold' => $product->sold,
            ]);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Data transaksi berhasil disimpan',
                'data' => $transaction
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);

        if(empty($transaction)) {
            return response()->json([
                'error' => true,
                'message' => 'Data transaksi tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'error' => false,
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transaction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if(empty($transaction)) {
            return response()->json([
                'error' => true,
                'message' => 'Data transaksi tidak ditemukan',
                'data' => null
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'error' => false,
            'message' => 'Data transaksi berhasil dihapus',
        ]);
    }
}
