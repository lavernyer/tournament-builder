<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use App\Domain\Tournament\TournamentId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Stage
{
    private int $incrementalId;
    private StageId $rootId;
    private ?StageId $nextId = null;
    private StageStatus $status;
    private Collection $divisions;
    private DateTimeImmutable $createdOn;
    private DateTimeImmutable $updatedOn;

    public function __construct(
        private StageId $id,
        private TournamentId $tournamentId,
    )
    {
        $this->rootId = $id;
        $this->status = StageStatus::FUTURE();
        $this->createdOn = $this->updatedOn = new DateTimeImmutable();
        $this->divisions = new ArrayCollection();
    }

    public function getId(): StageId
    {
        return $this->id;
    }

    public function getTournamentId(): TournamentId
    {
        return $this->tournamentId;
    }

    public function assignNext(self $stage): void
    {
        $this->nextId = $stage->getId();
        $stage->rootId = $this->rootId;
    }

    /**
     * @return Division[]
     */
    public function getDivisions(): array
    {
        return $this->divisions->toArray();
    }

    public function addDivision(string $key, Collection $rounds): Division
    {
        $this->divisions->add(new Division($this, $key, $rounds));

        return $this->divisions->last();
    }
}
