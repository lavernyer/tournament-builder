<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Key;

interface KeyGenerator
{
    public function generate(): string;
}