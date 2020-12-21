<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Competitor\CompetitorId;
use DateTimeImmutable;

final class Participant
{
    private int $id;
    private DateTimeImmutable $createdOn;

    public function __construct(
        private Tournament $tournament,
        private CompetitorId $competitorId,
        private string $name,
    )
    {
        $this->createdOn = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCompetitorId(): CompetitorId
    {
        return $this->competitorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function is(CompetitorId $competitorId): bool
    {
        return $this->competitorId->equals($competitorId);
    }
}