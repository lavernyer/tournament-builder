<?php

declare(strict_types=1);

namespace App\Application\Service\Tournament;

use App\Application\Dto\Tournament\ParticipantDto;
use App\Application\Exception\CompetitorNotFound;
use App\Application\Exception\TournamentNotFound;
use App\Domain\Competitor\CompetitorRepository;
use App\Domain\Tournament\TournamentRepository;
use Symfony\Component\Workflow\WorkflowInterface;

final class AddParticipantService
{
    public function __construct(
        private TournamentRepository $tournaments,
        private CompetitorRepository $competitors,
        private WorkflowInterface $tournamentWorkflow,
    ) {}

    public function execute(AddParticipant $command): ParticipantDto
    {
        $tournament = $this->tournaments->byId($command->getTournamentId())
            ?? throw TournamentNotFound::withId($command->getTournamentId());

        $competitor = $this->competitors->byId($command->getCompetitorId())
            ?? throw CompetitorNotFound::withId($command->getCompetitorId());

        $participant = $tournament->addParticipant($this->tournamentWorkflow, $competitor);
        $this->tournaments->update($tournament);

        return ParticipantDto::fromEntity($participant);
    }
}