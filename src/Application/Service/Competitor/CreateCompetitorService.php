<?php

declare(strict_types=1);

namespace App\Application\Service\Competitor;

use App\Application\Dto\Competitor\CompetitorDto;
use App\Domain\Competitor\CompetitorRepository;
use App\Domain\Competitor\Factory\CompetitorFactory;

final class CreateCompetitorService
{
    public function __construct(
        private CompetitorRepository $competitors,
        private CompetitorFactory $factory,
    ) {}

    public function execute(CreateCompetitor $command): CompetitorDto
    {
        $competitor = $this->factory->create($command->getCompetitor());
        $this->competitors->add($competitor);

        return CompetitorDto::fromEntity($competitor);
    }
}