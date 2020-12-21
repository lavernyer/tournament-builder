<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use App\Domain\Competitor\CompetitorId;

final class Matchup
{
    private int $id;

    public function __construct(
        private Round $round,
        private Participant $home,
        private Participant $guest,
    ) {}

    public function getHome(): Participant
    {
        return $this->home;
    }

    public function getGuest(): Participant
    {
        return $this->guest;
    }

    public function assignCompetitors(
        CompetitorId $homeId,
        string $homeName,
        string $homeKey,
        CompetitorId $guestId,
        string $guestName,
        string $guestKey
    ): void
    {
        $this->home->assignCompetitor($homeId, $homeName, $homeKey);
        $this->guest->assignCompetitor($guestId, $guestName, $guestKey);
    }

    public function setResult(int $homeScore, int $guestScore): void
    {
        $this->home->assignScore($homeScore);
        $this->guest->assignScore($guestScore);
    }
}