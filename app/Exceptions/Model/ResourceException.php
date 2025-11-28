<?php
declare(strict_types=1);

namespace App\Exceptions\Model;

use Exception;

class ResourceException extends Exception
{
    public static function notFound(string $modelName): self
    {
        return new self("Não foi possível encontrar nenhum {$modelName}");
    }

    public static function uniqueModel(string $modelName, string $field): self
    {
        return new self("Não foi possível criar o registro de {$modelName}, pois já existe um registro com esse {$field}");
    }
}
