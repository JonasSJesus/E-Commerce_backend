<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\JwtSession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class JwtSessionFactory extends Factory
{
    protected $model = JwtSession::class;

    public function definition(): array
    {
        return [
            'token_id'      => Str::random(10),
            'user_id'       => $this->faker->randomNumber(),
            'ip_address'    => $this->faker->ipv4(),
            'user_agent'    => $this->faker->word(),
            'last_activity' => Carbon::now(),
            'expires_at'    => Carbon::now(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()->addMinute(),
        ];
    }
}
