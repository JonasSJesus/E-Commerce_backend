<?php
declare(strict_types=1);

namespace App\Exceptions\Product;

use Exception;

class ProductException extends Exception
{
    public static function productNotFound(): self
    {
        return new self('Produto não encontrado');
    }
}
