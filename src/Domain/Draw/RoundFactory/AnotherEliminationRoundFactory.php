<?php

declare(strict_types=1);

namespace App\Domain\Draw\RoundFactory;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Round;

final class AnotherEliminationRoundFactory implements RoundFactory
{
    public function create(StageNode $request, array $participants): array
    {
        $participantCount = count($participants);

        $rounds = [];
        for ($r = 0; $r < $participantCount; $r += 2) {
            $round = new Round();
            $round->addMatchup($participants[$r], $participants[$r + 1]);
            $rounds[] = $round;
        }

        return $rounds;
    }
}