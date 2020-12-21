<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

final class TournamentConfig
{
    public function __construct(
        private TournamentBracket $bracket,
        private int $divisionCount,
        private int $participantCount,
        private int $qualifyCount,
    )
    {
    }

    public function getBracket(): TournamentBracket
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

    public function maxParticipants(): int
    {
        return $this->participantCount;
    }

    public function toArray(): array
    {
        return [
            'bracket' => $this->bracket->config(),
            'divisionCount' => $this->divisionCount,
            'participantCount' => $this->participantCount,
            'qualifyCount' => $this->qualifyCount,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            TournamentBracket::fromString($data['bracket']),
            $data['divisionCount'],
            $data['participantCount'],
            $data['qualifyCount'],
        );
    }
}