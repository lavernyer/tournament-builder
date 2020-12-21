<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Model;

use JetBrains\PhpStorm\Pure;

trait EnumTrait
{
    #[Pure]
    public function toString(): string
    {
        return $this->__toString();
    }

    #[Pure]
    public static function fromString(string $string): static
    {
        return new static($string);
    }
}