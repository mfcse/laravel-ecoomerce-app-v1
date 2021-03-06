<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create();

        $products = Product::all();
        foreach ($products as $product) {
            $product->addMediaFromUrl('https://via.placeholder.com/640x480.png/00aa00?text=veniam')
                ->toMediaCollection('products');
        }
    }
}