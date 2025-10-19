<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 3,
                'category_id' => 11,
                'name' => 'T-Shirt Oversized Putih',
                'description' => 'T-shirt lengan pendek, Ribbed round neck, Textured fabric, Material: CVC, Fit: Regular, Color: Beige, Model info: Model Height 183 cm, Bust: 86 cm, Waist: 72 cm, Hips: 82 cm, Art: 1-TSRCRT125C216',
                'price' => 109000.00,
                'stock' => 10,
                'image' => 'products/oC7tVtzQhRxW7iNObhtlG4GlBa7CBWSgikvgZOgi.webp',
                'slug' => 't-shirt-oversized-putih',
            ],
            [
                'id' => 4,
                'category_id' => 12,
                'name' => 'Regular Fit Textured Short Sleeve Shirt',
                'description' => 'Kemeja lengan pendek, Square front pocket, Textured fabric, Front button opening, Material: Cotton, Fit: Regular, Color: Indigo, Model info: Model Wearing Size 16, Model Height 185 cm, Bust: 91 cm, Waist: 80, Hips: 93 cm, Art: 1-SSRCRT225J250',
                'price' => 325000.00,
                'stock' => 10,
                'image' => 'products/qWJggVURZmmciTTGbQa0lc2kDFhdO4hZ1u97pZlo.webp',
                'slug' => 'regular-fit-textured-short-sleeve-shirt',
            ],
            [
                'id' => 5,
                'category_id' => 10,
                'name' => 'Slim Fit Basic Long Pants',
                'description' => 'Celana panjang basic, Double back pocket, Front zipper with button opening, Dilengkapi belt loop, Material: Polyester, Fit: Slim, Color: Taupe, Model info: Model Wearing Size 32, Model Height 185 cm, Chest: 91 cm, Waist: 77, Hips: 98 cm, Art: 1-LPIBSC525O214',
                'price' => 365415.00,
                'stock' => 15,
                'image' => 'products/8LSgnXg8AMlXpU5HIxZsGo4rlBHEcg2QF4uSQwJE.webp',
                'slug' => 'slim-fit-basic-long-pants',
            ],
            [
                'id' => 8,
                'category_id' => 15,
                'name' => 'Knitted Bomber Jacket',
                'description' => 'Jaket lengan panjang, Ribbed hem details, Front zipper opening, Textured knit fabric, Material: CVC Jacquard, Fit: Slim, Color: Beige, Model info: HEIGHT: 180, BUST: 90, WAIST: 75, HIPS: 92, Art: 1-JKICRT125D182',
                'price' => 499999.00,
                'stock' => 8,
                'image' => 'products/ha3ucAXLxkau4Ic3gJovpnvpXDiFPFfkdO3JpElX.webp',
                'slug' => 'knitted-bomber-jacket',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
