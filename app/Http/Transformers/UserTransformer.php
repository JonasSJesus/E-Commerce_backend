<?php
declare(strict_types=1);

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user): array
    {
        return [
            "id"    => $user->id,
            "nome"  => $user->name,
            "email" => $user->email,
            "fone"  => $user->phone,
            "ativo" => $user->active
        ];
    }
}
