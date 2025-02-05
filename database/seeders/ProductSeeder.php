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
    public function run()
    {
        $products = [
            ['product_category' => 1, 'product_name' => 'Jersey Liverpool', 'product_buying_price' => 1250000, 'product_quantity' => 120],
            ['product_category' => 1, 'product_name' => 'Dumbell 5kg', 'product_buying_price' => 80000, 'product_quantity' => 25],
            ['product_category' => 1, 'product_name' => 'Yoga Mat', 'product_buying_price' => 120000, 'product_quantity' => 30],
            ['product_category' => 2, 'product_name' => 'Gitar Akustik', 'product_buying_price' => 100000, 'product_quantity' => 10],
            ['product_category' => 2, 'product_name' => 'Drum Set', 'product_buying_price' => 2200000, 'product_quantity' => 5],
            ['product_category' => 1, 'product_name' => 'Bola Basket', 'product_buying_price' => 60000, 'product_quantity' => 40],
            ['product_category' => 2, 'product_name' => 'Piano Elektrik', 'product_buying_price' => 3000000, 'product_quantity' => 3],
            ['product_category' => 1, 'product_name' => 'Treadmill', 'product_buying_price' => 2000000, 'product_quantity' => 7],
            ['product_category' => 2, 'product_name' => 'Biola', 'product_buying_price' => 1400000, 'product_quantity' => 8],
            ['product_category' => 1, 'product_name' => 'Sepatu Lari', 'product_buying_price' => 200000, 'product_quantity' => 20],
        ];

        foreach ($products as $product) {
            Product::create([
                'product_category' => $product['product_category'],
                'product_name' => $product['product_name'],
                'product_buying_price' => $product['product_buying_price'],
                'product_selling_price' => $product['product_buying_price'] * 1.30,
                'product_quantity' => $product['product_quantity'],
                'product_image' => strtolower(str_replace(' ', '_', $product['product_name'])) . '.png',
            ]);
        }
    }
}
