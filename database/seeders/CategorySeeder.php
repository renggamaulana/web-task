<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Konsumsi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pembersih', 'created_at' => now(), 'updated_at' => now()],
        ];

        Category::insert($categories);
    }
}
