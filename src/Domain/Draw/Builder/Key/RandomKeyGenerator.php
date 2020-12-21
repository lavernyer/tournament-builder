<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Key;

final class RandomKeyGenerator implements KeyGenerator
{
    public function generate(): string
    {
        return uniqid();
    }
}