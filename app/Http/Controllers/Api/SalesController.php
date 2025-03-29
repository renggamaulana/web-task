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
        $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date'
        ]);

        $query = Transaction::selectRaw('categories.name as category, SUM(transactions.quantity) as total_sold')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->orderByRaw('SUM(transactions.quantity) DESC');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('transactions.transaction_date', [$request->start_date, $request->end_date]);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return response()->json([
                'error' => true,
                'error_message' => 'Tidak ada data penjualan',
                'data' => null
            ]);
        }

        $totalSales = $result->sum(fn($item) => $item->total_sold ?? 0);

        return response()->json([
            'error' => false,
            'message' => 'Data penjualan berhasil diambil',
            'data' => [
                'total_sales' => $totalSales,
                'total_categories' => $result->count(),
                'date_range' => [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ],
                'categories' => $result
            ],
        ]);
    }

}
