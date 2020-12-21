<?php

declare(strict_types=1);

namespace App\Application\Service\Tournament;

use App\Application\Dto\Tournament\CreateTournamentDto;

final class CreateTournament
{
    public function __construct(public CreateTournamentDto $tournament)
    {
    }
}