<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Competitor\Competitor;
use App\Domain\Competitor\CompetitorId;
use App\Domain\Competitor\CompetitorRepository;
use Doctrine\ORM\EntityManagerInterface;

final class OrmCompetitorRepository implements CompetitorRepository
{
    use RepositoryTrait;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->className = Competitor::class;
    }

    public function byId(CompetitorId $id): ?Competitor
    {
        return $this->getRepository()->findOneBy(['id' => $id->toString()]);
    }

    public function add(Competitor $competitor): void
    {
        $this->entityManager->persist($competitor);
        $this->entityManager->flush();
    }

    public function update(Competitor $competitor): void
    {
        $this->entityManager->persist($competitor);
        $this->entityManager->flush();
    }
}