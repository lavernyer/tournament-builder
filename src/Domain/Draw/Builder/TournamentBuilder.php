<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Stage;
use App\Domain\Draw\StageFactory\StageFactory;
use App\Domain\Draw\Participant;
use App\Domain\Draw\StageType;
use App\Domain\Tournament\TournamentId;

final class TournamentBuilder
{
    private ?StageNode $current = null;
    private array $unresolved = [];
    /**
     * @var Stage[]
     */
    private array $stages = [];

    public function __construct(private StageFactory $stageFactory)
    {
    }

    public function getCurrent(): ?StageNode
    {
        return $this->current;
    }

    public function setCurrent(StageNode $stage): void
    {
        $this->current = $stage;
    }

    public function roundRobin(string $name): StageNode
    {
        return $this->unresolved[] = new StageNode($this, $name, StageType::ROUND_ROBIN());
    }

    public function elimination(string $name): StageNode
    {
        return $this->unresolved[] = new StageNode($this, $name, StageType::ELIMINATION());
    }

    public function bracket(TournamentId $tournamentId, Participant ...$participants): array
    {
        foreach ($this->unresolved as $node) {
            $stage = $this->stageFactory->create($node, $tournamentId, $participants);
            if (current($this->stages)) {
                current($this->stages)->assignNext($stage);
                next($this->stages);
            }
            $this->stages[] = $stage;
            $participants = $this->emulateParticipants($node);
        }

        $this->unresolved = [];

        return $this->stages;
    }

    private function emulateParticipants(StageNode $stage): array
    {
        $count = $stage->getDivisions() * $stage->getQualify();
        $participants = [];
        for ($i = 0; $i < $count; $i++) {
            $participants[] = new Participant();
        }

        return $participants;
    }
}
