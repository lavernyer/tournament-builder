<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder;

use App\Domain\Tournament\TournamentId;

interface BracketFactory
{
    public function create(TournamentId $tournamentId): array;

    public function createBuilder(BuilderOptions $options): TournamentBuilder;
}
