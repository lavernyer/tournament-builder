<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Node;

final class LastChanceStageNode
{
    private StageNode $parent;
    private string $name;
    private string $type;

    public function __construct(StageNode $stage, string $name, string $type)
    {
        $this->parent = $stage;
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function end(): StageNode
    {
        return $this->parent;
    }
}