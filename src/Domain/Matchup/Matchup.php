<?php

declare(strict_types=1);

namespace App\Domain\Matchup;

use App\Domain\Competitor\CompetitorId;

final class Matchup
{
    private int $incrementalId;

    public function __construct(
        private MatchupId $id,
        private Draw $draw,
        private MatchupEntry $home,
        private MatchupEntry $guest,
        private CompetitorId $winner,
    )
    {
    }
}