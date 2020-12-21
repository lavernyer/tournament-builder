<?php

declare(strict_types=1);

namespace App\Domain\Draw\RoundFactory;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Round;

final class RoundRobinRoundFactory implements RoundFactory
{
    public function create(StageNode $request, array $participants): array
    {
        $rounds = [];
        $participantCount = $request->getParticipants() / $request->getDivisions();

        for ($r = 0; $r < $participantCount - 1; $r++) {
            $currentRound = $rounds[$r] = new Round();

            for ($i = 0; $i < $participantCount / 2; $i++) {
                $currentRound->addMatchup(
                    $participants[$i],
                    $participants[$participantCount - 1 - $i]
                );
            }

            $participants[] = array_splice($participants, 1, 1)[0];
        }

        $participants[] = array_splice($participants, 1, 1)[0];

        return $rounds;
    }
}