<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $ids = $this->createCategories();
        $this->createSubCategories($ids);
    }

    private function createCategories()
    {
        $categoryIds = [];
        $categories = $this->categories();

        foreach ($categories as $category) {
            $categoryIds[$category->name] = Category::factory()->create([
                'name' => $category->name,
                'slug' => $category->slug,
            ])->id;
        }

        return $categoryIds;
    }

    private function createSubCategories(?array $categoryIds = null)
    {
        $categories = $this->categories();

        foreach ($categories as $category) {
            foreach ($category->subcategories as $subCategory) {
                Category::factory()->create([
                    'name' => $subCategory['name'],
                    'slug' => $subCategory['slug'],
                    'parent_id' => $categoryIds[$category->name],
                ]);
            }
        }
    }

    private function categories(?int $parentId = null)
    {
        return [
            (object) [
                'name' => 'Masculinas',
                'slug' => 'masculinas',
                'subcategories' => (object) [
                    ['name' => 'Camisetas', 'slug' => 'camisetas-masculinas'],
                    ['name' => 'Camisas', 'slug' => 'camisas-masculinas'],
                    ['name' => 'Blusas', 'slug' => 'blusas-masculinas'],
                    ['name' => 'Casacos', 'slug' => 'casacos-masculinos'],
                    ['name' => 'Calças', 'slug' => 'calcas-masculinas'],
                    ['name' => 'Sapatos', 'slug' => 'sapatos-masculinos'],
                ]
            ],
            (object) [
                'name' => 'Femininas',
                'slug' => 'femininas',
                'subcategories' => (object) [
                    ['name' => 'Camisetas', 'slug' => 'camisetas-femininas'],
                    ['name' => 'Camisas', 'slug' => 'camisas-femininas'],
                    ['name' => 'Blusas', 'slug' => 'blusas-femininas'],
                    ['name' => 'Casacos', 'slug' => 'casacos-femininos'],
                    ['name' => 'Calças', 'slug' => 'calcas-femininas'],
                    ['name' => 'Sapatos', 'slug' => 'sapatos-femininos'],
                    ['name' => 'Shorts', 'slug' => 'shorts-femininos'],
                    ['name' => 'Saias',     'slug' => 'saias-femininas'],
                ]
            ]
        ];
    }
}
