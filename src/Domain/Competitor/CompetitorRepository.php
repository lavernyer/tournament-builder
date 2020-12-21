<?php

declare(strict_types=1);

namespace App\Domain\Competitor;

interface CompetitorRepository
{
    public function byId(CompetitorId $id): ?Competitor;

    public function add(Competitor $competitor): void;

    public function update(Competitor $competitor): void;
}