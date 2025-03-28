<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Sales Comparison
     *
     * @param   Request  $request
     *
     * @return  Model Transaction
     */
    public function salesSummary(Request $request)
    {
        $query = Transaction::selectRaw('categories.name as category, SUM(transactions.quantity) as total_sold')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->orderBy('total_sold', 'desc');

        // Cek apakah filter tanggal diberikan
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('transactions.transaction_date', [$startDate, $endDate]);
        }

        // Ambil hasil query
        $result = $query->get();

        // Hitung total penjualan dari semua kategori
        $totalSales = $result->sum('total_sold');

        return response()->json([
            'error' => false,
            'message' => 'Data penjualan berhasil diambil',
            'data' => [
                'total_sales' => $totalSales,
                'total_categories' => count($result),
                'date_range' => [
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                ],
                'categories' => $result
            ],
        ]);

    }
}
