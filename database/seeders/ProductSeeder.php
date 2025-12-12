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

        $states = ['cheap', 'expensive', 'outOfStock'];

        foreach ($this->products() as $productData) {
            $randomState = $states[array_rand($states)];
            Product::factory()->$randomState()->create($productData);
        }
    }

    public function products(): array
    {
        return [
            [
                'name' => 'Camiseta Básica Preta',
                'description' => 'Camiseta 100% algodão, cor preta, ideal para uso casual',
                'category_id' => 1,
                'slug' => 'camiseta-basica-preta'
            ],
            [
                'name' => 'Calça Jeans Slim',
                'description' => 'Calça jeans azul escuro, corte slim, cintura média',
                'category_id' => 2,
                'slug' => 'calca-jeans-slim'
            ],
            [
                'name' => 'Vestido Floral',
                'description' => 'Vestido longo estampa floral, tecido leve e fresco',
                'category_id' => 2,
                'slug' => 'vestido-floral'
            ],
            [
                'name' => 'Moletom Oversized',
                'description' => 'Moletom estilo oversized com capuz, cor cinza',
                'category_id' => 1,
                'slug' => 'moletom-oversized'
            ],
            [
                'name' => 'Blazer Social',
                'description' => 'Blazer social preto, corte moderno, tecido premium',
                'category_id' => 1,
                'slug' => 'blazer-social'
            ],
//            [
//                'name' => 'Tênis Esportivo Branco',
//                'description' => 'Tênis branco com detalhes coloridos, ideal para corrida e academia',
//                'category_id' => 3
//            ],
            [
                'name' => 'Jaqueta de Couro',
                'description' => 'Jaqueta de couro sintético preta, estilo motoqueiro',
                'category_id' => 1,
                'slug' => 'jaqueta-de-couro'
            ],
            [
                'name' => 'Saia Midi Plissada',
                'description' => 'Saia midi plissada, cor nude, tecido fluido',
                'category_id' => 2,
                'slug' => 'saia-midi-plissada'
            ],
            [
                'name' => 'Camisa Social Branca',
                'description' => 'Camisa social branca, manga longa, tecido anti-amassado',
                'category_id' => 1,
                'slug' => 'camisa-social-branca'
            ],
            [
                'name' => 'Short Jeans Destroyed',
                'description' => 'Short jeans com rasgos e destroyed, cintura alta',
                'category_id' => 2,
                'slug' => 'short-jeans-destroyed'
            ],
            [
                'name' => 'Blusa de Tricot',
                'description' => 'Blusa de tricot canelado, gola alta, cor caramelo',
                'category_id' => 2,
                'slug' => 'blusa-de-tricot'
            ],
            [
                'name' => 'Calça Cargo Bege',
                'description' => 'Calça cargo com bolsos laterais, cor bege, estilo utilitário',
                'category_id' => 1,
                'slug' => 'calca-cargo-bege'
            ],
            [
                'name' => 'Cropped Branco Canelado',
                'description' => 'Cropped branco canelado, manga longa, gola alta',
                'category_id' => 2,
                'slug' => 'cropped-branco-canelado'
            ],
            [
                'name' => 'Macacão Jeans',
                'description' => 'Macacão jeans azul claro, modelagem reta',
                'category_id' => 2,
                'slug' => 'macacao-jeans'
            ],
//            [
//                'name' => 'Boné Snapback',
//                'description' => 'Boné snapback preto com logo bordado',
//                'category_id' => 4
//            ],
//            [
//                'name' => 'Cinto de Couro Marrom',
//                'description' => 'Cinto de couro legítimo marrom, fivela dourada',
//                'category_id' => 4
//            ],
            [
                'name' => 'Regata Fitness',
                'description' => 'Regata fitness preta, tecido dry fit, respirável',
                'category_id' => 2,
                'slug' => 'regata-fitness'
            ],
            [
                'name' => 'Legging Estampada',
                'description' => 'Legging com estampa geométrica, cintura alta, tecido suplex',
                'category_id' => 2,
                'slug' => 'legging-estampada'
            ],
//            [
//                'name' => 'Óculos de Sol Aviador',
//                'description' => 'Óculos de sol estilo aviador, lente espelhada, proteção UV400',
//                'category_id' => 4
//            ],
//            [
//                'name' => 'Mochila Notebook',
//                'description' => 'Mochila executiva com compartimento para notebook até 15.6 polegadas',
//                'category_id' => 4
//            ]
        ];
    }
}
