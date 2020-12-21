<?php

declare(strict_types=1);

namespace App\Domain\Competitor;

final class Competitor
{
    private int $incrementalId;

    public function __construct(
        private CompetitorId $id,
        private string $name
    ) {}

    public function getId(): CompetitorId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}