<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder;

final class BuilderOptions
{
    public function __construct(
        private ?string $bracket,
        private int $divisionCount,
        private int $participantCount,
        private int $qualifyCount,
    ) {}

    public function getBracket(): ?string
    {
        return $this->bracket;
    }

    public function getDivisionCount(): int
    {
        return $this->divisionCount;
    }

    public function getParticipantCount(): int
    {
        return $this->participantCount;
    }

    public function getQualifyCount(): int
    {
        return $this->qualifyCount;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['bracket'],
            $data['divisionCount'],
            $data['participantCount'],
            $data['qualifyCount'],
        );
    }
}