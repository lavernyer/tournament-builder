<?php

declare(strict_types=1);

namespace App\Domain\Draw\StageFactory;

use App\Domain\Draw\Builder\Key\KeyGenerator;
use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Stage;
use App\Domain\Draw\StageId;
use App\Domain\Tournament\TournamentId;
use App\Domain\Draw\RoundFactory\RoundFactory;
use Doctrine\Common\Collections\ArrayCollection;

final class RoundRobinStageFactory implements StageFactory
{
    public function __construct(
        private RoundFactory $roundRobinFactory,
        private KeyGenerator $keyGenerator
    )
    {
    }

    public function create(StageNode $request, TournamentId $tournamentId, array $participants): Stage
    {
        $divisions = array_chunk(
            $participants,
            $request->getParticipants() / $request->getDivisions()
        );
        $stage = new Stage(StageId::create(), $tournamentId);

        foreach ($divisions as $basketParticipants) {
            $divisionRounds = $this->roundRobinFactory->create($request, $basketParticipants);
            $stage->addDivision($this->keyGenerator->generate(), new ArrayCollection($divisionRounds));
        }

        $request->setStage($stage);

        return $stage;
    }

    public function supports(StageNode $request): bool
    {
        return $request->isRoundRobin();
    }
}