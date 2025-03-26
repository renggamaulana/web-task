<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            $product = Product::find($transaction['product_id']);

            if ($product && $product->stock >= $transaction['quantity']) {
                Transaction::create($transaction);
                $product->decrement('stock', $transaction['quantity']); // Mengurangi stok
                $product->increment('sold', $transaction['quantity']); // Menambah jumlah terjual
            }
        }
    }
}
