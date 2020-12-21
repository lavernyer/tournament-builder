<?php

declare(strict_types=1);

namespace App\Domain\Draw\RoundFactory;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Round;

final class FirstEliminationRoundFactory implements RoundFactory
{
    public function create(StageNode $request, array $participants): array
    {
        $divisions = array_chunk(
            $participants,
            $request->getParticipants() / 2
        );

        $divisionCount = count($divisions);
        $qualifiedCount = count($divisions[0]);

        $rounds = [];

        for ($r = 0; $r < $divisionCount / 2; $r++) {
            foreach ($divisions[$r] as $key => $participant) {
                $opponentIndex = $qualifiedCount - ($key + 1);
                $round = new Round();
                $round->addMatchup($participant, $divisions[$divisionCount - $r - 1][$opponentIndex]);
                $rounds[] = $round;
            }
        }

        return $rounds;
    }
}