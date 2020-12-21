<?php

declare(strict_types=1);

namespace App\Domain\Tournament\Factory;

use App\Application\Dto\Tournament\CreateTournamentDto;
use App\Domain\Tournament\Tournament;
use App\Domain\Tournament\TournamentConfig;
use App\Domain\Tournament\TournamentId;

final class DefaultTournamentFactory implements TournamentFactory
{
    public function create(CreateTournamentDto $dto): Tournament
    {
        return new Tournament(
            TournamentId::create(),
            TournamentConfig::fromArray(get_object_vars($dto)),
        );
    }
}