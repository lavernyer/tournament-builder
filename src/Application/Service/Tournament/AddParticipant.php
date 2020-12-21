<?php

declare(strict_types=1);

namespace App\Application\Service\Tournament;

use App\Domain\Competitor\CompetitorId;
use App\Domain\Tournament\TournamentId;

final class AddParticipant
{
    public function __construct(
        private TournamentId $tournamentId,
        private CompetitorId $competitorId,
    ) {}

    public function getTournamentId(): TournamentId
    {
        return $this->tournamentId;
    }

    public function getCompetitorId(): CompetitorId
    {
        return $this->competitorId;
    }
}