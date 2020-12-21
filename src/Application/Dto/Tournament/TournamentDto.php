<?php

declare(strict_types=1);

namespace App\Application\Dto\Tournament;

use App\Domain\Tournament\Participant;
use App\Domain\Tournament\Tournament;
use DateTimeImmutable;

final class TournamentDto
{
    public function __construct(
        public string $id,
        public string $state,
        public array $participants,
        public ?ParticipantDto $winner,
        public array $config,
        public DateTimeImmutable $createdOn,
        public DateTimeImmutable $updatedOn,
    ) {}

    public static function fromEntity(Tournament $tournament): self
    {
        return new self(
            $tournament->getId()->toString(),
            $tournament->getStatus()->toString(),
            array_map(
                static fn(Participant $participant) => ParticipantDto::fromEntity($participant),
                $tournament->getParticipants()
            ),
            $tournament->getWinner() ? ParticipantDto::fromEntity($tournament->getWinner()) : null,
            $tournament->getConfig()->toArray(),
            $tournament->getCreatedOn(),
            $tournament->getUpdatedOn(),
        );
    }
}