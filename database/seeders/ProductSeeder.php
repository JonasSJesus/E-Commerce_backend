<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->createFakeProducts();
    }

    private function createFakeProducts(): void
    {
        Product::factory()->withCategory()->count(10)->create();
        Product::factory()->cheap()->withCategory()->count(5)->create();
        Product::factory()->expensive()->withCategory()->count(5)->create();
        Product::factory()->outOfStock()->withCategory()->count(5)->create();
    }
}
