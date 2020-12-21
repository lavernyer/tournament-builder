<?php

declare(strict_types=1);

namespace App\Domain\Draw\StageFactory;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Stage;
use App\Domain\Tournament\TournamentId;

interface StageFactory
{
    public function create(StageNode $request, TournamentId $tournamentId, array $participants): Stage;
    public function supports(StageNode $request): bool;
}