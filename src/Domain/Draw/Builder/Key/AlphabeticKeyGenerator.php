<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Key;

use Exception;

final class AlphabeticKeyGenerator implements KeyGenerator
{
    private array $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    private int $length = 0;
    private string $prefix = '';

    public function generate(): string
    {
        $current = $this->prefix . current($this->alphabet);
        $next = next($this->alphabet);

        if (false === $next) {
            if ($this >= 26) {
                throw new Exception('Maximal name generation has been exceeded');
            }

            reset($this->alphabet);
            $this->prefix = $this->alphabet[$this->length];
            $this->length++;
        }

        return $current;
    }
}