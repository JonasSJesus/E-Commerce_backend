<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $this->runProductFakeSeeder();
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }

    private function runProductFakeSeeder()
    {
        $this->command->alert('Seed de produtos');
        $this->call(ProductSeeder::class);

        // Mensagem verde (sucesso)
        $this->command->info('produtos criados com sucesso');
    }

    private function runUserFakeSeeder()
    {
        $this->call(UserSeeder::class);
    }
}
