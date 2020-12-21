<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use Doctrine\Common\Collections\Collection;

final class Division
{
    private int $id;

    public function __construct(
        private Stage $stage,
        private string $key,
        private Collection $rounds,
    )
    {
        foreach ($this->rounds as $round) {
            $round->assignDivision($this);
        }
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getRounds(): array
    {
        return $this->rounds->toArray();
    }
}