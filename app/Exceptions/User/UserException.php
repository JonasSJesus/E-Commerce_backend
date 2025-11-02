<?php
declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;

class UserException extends Exception
{
    public static function userNotFound(): self
    {
        return new self("Nenhum usuário encontrado");
    }

    public static function emailAlreadyExists(): self
    {
        return new self("Email já está em uso!");
    }
}
