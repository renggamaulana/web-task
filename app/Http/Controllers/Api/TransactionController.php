<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        return response()->json([
            'error' => false,
            'data' => $transactions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $transaction = Transaction::create($request->validated());

        return response()->json([
            'error' => false,
            'message' => 'Data transaksi berhasil disimpan',
            'data' => $transaction
        ]);
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
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $id)
    {
        $transaction = Transaction::find($id);

        if(empty($transaction)) {
            return response()->json([
                'error' => true,
                'message' => 'Data transaksi tidak ditemukan',
                'data' => null
            ], 404);
        }

        $transaction->update($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Data transaksi berhasil diubah',
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
