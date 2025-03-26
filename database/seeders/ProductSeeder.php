<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Kopi',
                'stock' => 100,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Teh',
                'stock' => 100,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pasta Gigi',
                'stock' => 100,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sabun Mandi',
                'stock' => 100,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sampo',
                'stock' => 100,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Product::insert($products);
    }
}
