<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Tournament\Tournament;
use App\Domain\Tournament\TournamentId;
use App\Domain\Tournament\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;

final class OrmTournamentRepository implements TournamentRepository
{
    use RepositoryTrait;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->className = Tournament::class;
    }

    public function byId(TournamentId $id): ?Tournament
    {
        return $this->getRepository()->findOneBy(['id' => $id->toString()]);
    }

    public function add(Tournament $tournament): void
    {
        $this->entityManager->persist($tournament);
        $this->entityManager->flush();
    }

    public function update(Tournament $tournament): void
    {
        $this->entityManager->persist($tournament);
        $this->entityManager->flush();
    }
}