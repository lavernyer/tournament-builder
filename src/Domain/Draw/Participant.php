<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use App\Domain\Competitor\CompetitorId;

final class Participant
{
    public function __construct(
        private ?CompetitorId $competitorId = null,
        private ?string $name = null,
        private ?string $key = null,
        private ?int $score = null,
    ) {}

    public function getCompetitorId(): ?CompetitorId
    {
        return $this->competitorId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function assignKey(string $key): void
    {
        $this->key = $key;
    }

    public function assignCompetitor(CompetitorId $competitorId, string $name, string $key): self
    {
        return new self($competitorId, $name, $key);
    }

    public function assignScore(int $score): void
    {
        $this->score = $score;
    }
}