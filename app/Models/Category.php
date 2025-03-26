<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    protected $fillable = ['name'];

    /**
     * Relationship to Product
     *
     * @return  Model Product
     */
    public function product() {
        return $this->hasMany(Product::class);
    }
}
