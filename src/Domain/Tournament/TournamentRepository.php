<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

interface TournamentRepository
{
    public function byId(TournamentId $id): ?Tournament;

    public function add(Tournament $tournament): void;

    public function update(Tournament $tournament): void;

//    public function paginate($criteria): Pagerfanta;
}