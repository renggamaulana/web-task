<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            ['product_id' => 1, 'quantity' => 10, 'transaction_date' => '2021-05-01'],
            ['product_id' => 2, 'quantity' => 19, 'transaction_date' => '2021-05-05'],
            ['product_id' => 1, 'quantity' => 15, 'transaction_date' => '2021-05-10'],
            ['product_id' => 3, 'quantity' => 20, 'transaction_date' => '2021-05-11'],
            ['product_id' => 4, 'quantity' => 30, 'transaction_date' => '2021-05-11'],
            ['product_id' => 5, 'quantity' => 25, 'transaction_date' => '2021-05-12'],
            ['product_id' => 2, 'quantity' => 5, 'transaction_date' => '2021-05-12'],
        ];

        foreach ($transactions as $transaction) {
            DB::transaction(function () use ($transaction) {
                $product = Product::find($transaction['product_id']);

                if ($product && $product->stock >= $transaction['quantity']) {
                    $previousStock = $product->stock;
                    $newStock = $previousStock - $transaction['quantity'];

                    $previousSold = $product->sold;
                    $newSold = $previousSold + $transaction['quantity'];

                    // Buat transaksi
                    $newTransaction = Transaction::create([
                        'product_id' => $transaction['product_id'],
                        'quantity' => $transaction['quantity'],
                        'transaction_date' => $transaction['transaction_date'],
                    ]);

                    // Update stok & jumlah terjual
                    $product->update([
                        'stock' => $newStock,
                        'sold' => $newSold,
                    ]);

                    // Simpan ke transaction_log
                    TransactionLog::create([
                        'transaction_id' => $newTransaction->id,
                        'product_id' => $transaction['product_id'],
                        'quantity' => $transaction['quantity'],
                        'previous_stock' => $previousStock,
                        'new_stock' => $newStock,
                        'previous_sold' => $previousSold,
                        'new_sold' => $newSold,
                    ]);
                }
            });
        }
    }
}
