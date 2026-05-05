<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all subcategories, create them if none exist
        $subCategories = SubCategory::all();
        if ($subCategories->isEmpty()) {
            $subCategories = SubCategory::factory(5)->create();
        }

        // Create 20 products with images
        Product::factory(20)
            ->sequence(
                fn($sequence) => [
                    'sub_category_id' => $subCategories->random()->id,
                ]
            )
            ->create();
    }
}
