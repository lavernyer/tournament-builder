<?php

declare(strict_types=1);

namespace App\Domain\Tournament\Factory;

use App\Application\Dto\Tournament\CreateTournamentDto;
use App\Domain\Tournament\Tournament;

interface TournamentFactory
{
    public function create(CreateTournamentDto $dto): Tournament;
}