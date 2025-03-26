<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_create_transaction(): void
    {
        // Buat barang terlebih dahulu
        $product = Product::factory()->create([
                'stock' => 100
        ]);

        // Data transaksi yang akan dikirim
        $data = [
            'product_id' => $product->id,
            'quantity' => 10,
            'transaction_date' => now()->toDateString(),
        ];

        // Kirim request POST ke endpoint API
        $response = $this->postJson('/api/transactions', $data);

        // Periksa apakah response sukses
        $response->assertStatus(201)
            ->assertJson([
                'error' => false,
                'message' => 'Data transaksi berhasil disimpan',
            ]);

        // Pastikan transaksi masuk ke database
        $this->assertDatabasehas('transactions', [
            'product_id' => $product->id,
            'quantity' => 10
        ]);

        // Pastikan stok barang berkurang
        $this->assertEquals(40, $product->fresh()->stock);
    }

    public function test_cannot_create_transaction_with_insufficient_stock()
    {
        $product = Product::factory()->create([
            'stock' => 5, // stock lebih kecil dari quantity
        ]);

        $data = [
            'product_id' => $product->id,
            'quantity' => 10,
            'transaction_date' => now()->toDateString(),
        ];

        $response = $this->postJson('/api/transactions', $data);

        // Pastikan response error 422 (validasi gagal)
        $response->assertStatus(422)
            ->assertJson([
                'error' => true,
                'message' => 'Stock tidak mencukupi'
            ]);

        // Pastikan tidak ada transaksi yang masuk ke database
        $this->assertDatabaseMissing('transactions', [
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

    }
}
