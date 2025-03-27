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
    public function compareSales(Request $request)
    {
        $query = Transaction::selectRaw('categories.name as category, SUM(transactions.quantity) as total_sold')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->orderBy('total_sold', 'desc');

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Jika ada tanggal, tambahkan filter berdasarkan rentang waktu
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('transactions.transaction_date', [$startDate, $endDate]);
        }

        $result = $query->get();

        $totalSales = $result->sum('total_sold');

        return response()->json([
            'error' => false,
            'message' => 'Data penjualan berhasil diambil',
            'data' => [
                'total_sales' => $totalSales,
                'total_categories' => count($result),
                'date_range' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
                'categories' => $result
            ],
        ]);
    }
}
