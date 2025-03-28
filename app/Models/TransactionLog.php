<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_logs';
    protected $fillable = [
        'transaction_id', 'product_id', 'quantity',
        'previous_stock', 'new_stock',
        'previous_sold', 'new_sold'
    ];

    // Relasi ke Transaction (Setiap log terkait dengan satu transaksi)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke Product (Setiap log terkait dengan satu produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
