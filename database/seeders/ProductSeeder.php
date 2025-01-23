<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'description' => 'Description of product 1',
            'price' => 19.99,
        ]);
        Product::create([
            'name' => 'Product 2',
            'description' => 'Description of product 2',
            'price' => 29.99,
        ]);
		Product::create([
            'name' => 'Product 3',
            'description' => 'Description of product 3',
            'price' => 50.00,
        ]);
		Product::create([
            'name' => 'Product 4',
            'description' => 'Description of product 4',
            'price' => 40.00,
        ]);
		Product::create([
            'name' => 'Product 5',
            'description' => 'Description of product 5',
            'price' => 60.00,
        ]);
    }
}
