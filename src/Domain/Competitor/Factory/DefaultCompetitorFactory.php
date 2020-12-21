<?php

declare(strict_types=1);

namespace App\Domain\Competitor\Factory;

use App\Application\Dto\Competitor\CreateCompetitorDto;
use App\Domain\Competitor\Competitor;
use App\Domain\Competitor\CompetitorId;

final class DefaultCompetitorFactory implements CompetitorFactory
{
    public function create(CreateCompetitorDto $dto): Competitor
    {
        return new Competitor(CompetitorId::create(), $dto->name);
    }
}