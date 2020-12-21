<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder;

use App\Domain\Draw\Builder\Struct\EmptyTournamentStruct;
use App\Domain\Draw\StageFactory\StageFactory;
use App\Domain\Draw\Participant;
use App\Domain\Tournament\Participant as TournamentParticipant;
use App\Domain\Tournament\TournamentId;
use App\Domain\Tournament\TournamentRepository;
use RuntimeException;

final class DefaultBracketFactory implements BracketFactory
{
    private TournamentRegistry $tournamentRegistry;
    private TournamentRepository $tournaments;
    private StageFactory $stageFactory;

    public function __construct(
        TournamentRegistry $tournamentRegistry,
        TournamentRepository $tournaments,
        StageFactory $stageFactory
    )
    {
        $this->tournamentRegistry = $tournamentRegistry;
        $this->tournaments = $tournaments;
        $this->stageFactory = $stageFactory;
    }

    public function create(TournamentId $tournamentId): array
    {
        $tournament = $this->tournaments->byId($tournamentId) ?? throw new RuntimeException();
        $options = BuilderOptions::fromArray($tournament->getConfig()->toArray());

        return $this
            ->createBuilder($options)
            ->bracket($tournament->getId(), ...$this->mapParticipants($tournament->getParticipants()));
    }

    public function createBuilder(BuilderOptions $options): TournamentBuilder
    {
        $bracketClass = $options->getBracket() ?? EmptyTournamentStruct::class;
        $tournament = $this->tournamentRegistry->getTournamentBracket($bracketClass);

        // For now implemented only builder configuration, but in future bracket configuration can be described
        // in database
        $builder = new TournamentBuilder($this->stageFactory);

        $tournament->build($builder, $options);

        return $builder;
    }

    private function mapParticipants(array $participants): array
    {
        return array_map(
            static fn(TournamentParticipant $p) => new Participant($p->getCompetitorId(), $p->getName()),
            $participants
        );
    }
}
