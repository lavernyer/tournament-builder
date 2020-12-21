<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Node;

use App\Domain\Draw\Builder\TournamentBuilder;
use App\Domain\Draw\Stage;
use App\Domain\Draw\StageType;

final class StageNode
{
    private TournamentBuilder $builder;
    private ?StageNode $previous;
    private ?LastChanceStageNode $child;
    private string $name;
    private StageType $type;
    private int $participants;
    private int $divisions;
    private int $qualify;
    private Stage $stage;

    public function __construct(
        TournamentBuilder $builder,
        string $name,
        StageType $type
    )
    {
        $this->builder = $builder;
        $this->previous = $builder->getCurrent();
        $this->name = $name;
        $this->type = $type;
        $this->qualify = 1;

        if (null !== $this->previous && $this->isElimination()) {
            $this->divisions = $this->previous->getParticipants() / 4;
            $this->participants = $this->previous->getParticipants() / 2;
        }
    }

    public function setStage(Stage $stage): void
    {
        if (isset($this->stage)) {
            throw new \Exception();
        }

        $this->stage = $stage;
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }

    public function setParticipants(int $count): self
    {
        $this->participants = $count;

        return $this;
    }

    public function setDivisions(int $count): self
    {
        $this->divisions = $count;

        return $this;
    }

    public function setQualify(int $count): self
    {
        $this->qualify = $count;

        return $this;
    }

    public function getPrevious(): ?StageNode
    {
        return $this->previous;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): StageType
    {
        return $this->type;
    }

    public function getParticipants(): int
    {
        return $this->participants;
    }

    public function getDivisions(): int
    {
        return $this->divisions;
    }

    public function getQualify(): int
    {
        return $this->qualify;
    }

    public function isRoundRobin(): bool
    {
        return $this->type->isRoundRobin();
    }

    public function isElimination(): bool
    {
        return $this->type->isElimination();
    }

    public function stage(string $name, string $type): LastChanceStageNode
    {
        return $this->child = new LastChanceStageNode($this, $name, $type);
    }

    public function end(): TournamentBuilder
    {
        $this->builder->setCurrent($this);

        return $this->builder;
    }
}