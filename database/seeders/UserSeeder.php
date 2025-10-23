<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUser();
    }

    private function createUser(): void
    {
        $user = User::query();

        $user->create([
            "name"  => "Admin",
            "email" => "admin@jonassj.com.br",
            "password" => Hash::make("123123"),
            "role"     => "admin",
        ]);
    }

    private function createFakeUsers(): void
    {
        User::factory();
    }
}
