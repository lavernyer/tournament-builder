<?php

declare(strict_types=1);

namespace App\Application\Service\Tournament;

use App\Application\Dto\Tournament\TournamentDto;
use App\Domain\Tournament\Factory\TournamentFactory;
use App\Domain\Tournament\TournamentRepository;

final class CreateTournamentService
{
    public function __construct(
        private TournamentRepository $tournaments,
        private TournamentFactory $factory,
    ) {}

    public function execute(CreateTournament $command): TournamentDto
    {
        $tournament = $this->factory->create($command->tournament);
        $this->tournaments->add($tournament);

        return TournamentDto::fromEntity($tournament);
    }
}