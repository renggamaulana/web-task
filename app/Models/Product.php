<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'stock',
        'sold',
        'category_id',
    ];

    /**
     * Relationship to Category
     *
     * @return Model Category
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship to Transaction
     *
     * @return Model Transaction
     */
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    // Relasi ke TransactionLog (Satu produk bisa memiliki banyak log transaksi)
    public function transactionLogs()
    {
        return $this->hasMany(TransactionLog::class);
    }
}
