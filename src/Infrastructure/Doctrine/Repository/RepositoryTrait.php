<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;

trait RepositoryTrait
{
    private string $className;

    private function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select($alias)
            ->from($this->className, $alias);
    }

    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->className);
    }
}
