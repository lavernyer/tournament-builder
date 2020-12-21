<?php

declare(strict_types=1);

namespace App\Domain\Tournament\Event;

use App\Domain\Tournament\TournamentId;
use DateTimeImmutable;

final class TournamentSignupCompleted
{
    public function __construct(
        private TournamentId $tournamentId,
        private DateTimeImmutable $occurredOn,
    )
    {
    }

    public function getTournamentId(): TournamentId
    {
        return $this->tournamentId;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}