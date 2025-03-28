<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = [
        'quantity',
        'product_id',
        'transaction_date',
    ];

    /**
     * Relationship to Product
     *
     * @return  Model Product
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
    // Relasi ke TransactionLog (Satu transaksi bisa memiliki banyak log)
    public function transactionLogs()
    {
        return $this->hasMany(TransactionLog::class);
    }
}
