<?php

declare(strict_types=1);

namespace App\Application\Service\Competitor;

use App\Application\Dto\Competitor\CreateCompetitorDto;

final class CreateCompetitor
{
    public function __construct(private CreateCompetitorDto $competitor)
    {}

    public function getCompetitor(): CreateCompetitorDto
    {
        return $this->competitor;
    }
}