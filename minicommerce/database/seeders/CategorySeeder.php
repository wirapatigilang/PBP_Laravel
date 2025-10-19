<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 10, 'name' => 'Celana'],
            ['id' => 11, 'name' => 'T-Shirt'],
            ['id' => 12, 'name' => 'Kemeja'],
            ['id' => 13, 'name' => 'Accesioris'],
            ['id' => 14, 'name' => 'Orang Hilang'],
            ['id' => 15, 'name' => 'Outerwear'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
