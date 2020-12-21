<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Draw\Stage;
use App\Domain\Draw\StageId;
use App\Domain\Draw\StageRepository;
use Doctrine\ORM\EntityManagerInterface;

final class OrmStageRepository implements StageRepository
{
    use RepositoryTrait;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->className = Stage::class;
    }

    public function byId(StageId $id): ?Stage
    {
        return $this->getRepository()->findOneBy(['id' => $id->toString()]);
    }

    public function add(Stage $stage): void
    {
        $this->entityManager->persist($stage);
        $this->entityManager->flush();
    }

    public function addMulti(Stage ...$stages): void
    {
        foreach ($stages as $stage) {
            $this->entityManager->persist($stage);
        }

        $this->entityManager->flush();
    }

    public function update(Stage $stage): void
    {
        $this->entityManager->persist($stage);
        $this->entityManager->flush();
    }
}