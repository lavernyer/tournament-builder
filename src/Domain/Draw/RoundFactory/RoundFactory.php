<?php

declare(strict_types=1);

namespace App\Domain\Draw\RoundFactory;

use App\Domain\Draw\Builder\Node\StageNode;

interface RoundFactory
{
    public function create(StageNode $request, array $participants): array;
}