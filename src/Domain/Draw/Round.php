<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Round
{
    private int $id;
    private Division $division;
    private Collection $matchups;

    public function __construct(Matchup ...$matchups)
    {
        $this->matchups = new ArrayCollection($matchups);
    }

    public function assignDivision(Division $division): void
    {
        $this->division = $division;
    }

    public function addMatchup(Participant $home, Participant $guest): Matchup
    {
        $this->matchups->add(new Matchup($this, $home, $guest));

        return $this->matchups->last();
    }

    public function getMatchups(): array
    {
        return $this->matchups->toArray();
    }
}