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
use Symfony\Component\Config\Definition\Exception\Exception;

final class AnotherEliminationStageFactory implements StageFactory
{
    public function __construct(
        private RoundFactory $anotherEliminationFactory,
        private KeyGenerator $randomGenerator
    ){}

    public function create(StageNode $request, TournamentId $tournamentId, array $participants): Stage
    {
        $previous = $request->getPrevious() ?? throw new Exception('Previous stage cannot be null');

        foreach ($previous->getStage()->getDivisions() as $division) {
            current($participants)->assignKey($division->getKey());
            next($participants);
        }

        reset($participants);

        $stage = new Stage(StageId::create(), $tournamentId);
        $divisionRounds = $this->anotherEliminationFactory->create($request, $participants);
        foreach ($divisionRounds as $round) {
            $stage->addDivision($this->randomGenerator->generate(), new ArrayCollection([$round]));
        }

        $request->setStage($stage);

        return $stage;
    }

    public function supports(StageNode $request): bool
    {
        return $request->isElimination() && (bool)$request->getPrevious()?->isElimination();
    }
}