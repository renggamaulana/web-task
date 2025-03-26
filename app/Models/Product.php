<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'stock',
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
    public function transaction() {
        return $this->hasMany(Transaction::class);
    }
}
