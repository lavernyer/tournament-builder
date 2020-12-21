<?php

declare(strict_types=1);

namespace App\Domain\Competitor\Factory;

use App\Application\Dto\Competitor\CreateCompetitorDto;
use App\Domain\Competitor\Competitor;

interface CompetitorFactory
{
    public function create(CreateCompetitorDto $dto): Competitor;
}