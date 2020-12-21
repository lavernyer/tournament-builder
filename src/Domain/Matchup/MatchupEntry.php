<?php

declare(strict_types=1);

namespace App\Domain\Matchup;

use App\Domain\Competitor\CompetitorId;

final class MatchupEntry
{
    public function __construct(
        private CompetitorId $competitorId,
        private string $name,
        private int $score,
    )
    {
    }
}