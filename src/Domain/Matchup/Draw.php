<?php

declare(strict_types=1);

namespace App\Domain\Matchup;

use App\Domain\Draw\StageId;
use App\Domain\Tournament\TournamentId;

final class Draw
{
    public function __construct(
        private TournamentId $tournamentId,
        private StageId $stageId,
        private int $divisionId,
        private int $roundId
    )
    {
    }
}