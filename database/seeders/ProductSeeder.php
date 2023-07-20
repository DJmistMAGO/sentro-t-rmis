<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Product::where('product_name', 'product1')->exists()) {
            Product::create([
                'product_name' => 'product1',
                'product_code' => 'product1',
                'description' => 'product1',
                'category' => 'product1',
                'price' => 'product1',
                'quantity' => 'product1',
                'image' => 'product1',
                'status' => 'product1',
                'supplier_info' => 'product1',
            ]);
        }
    }
}
