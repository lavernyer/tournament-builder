<?php

declare(strict_types=1);

namespace App\Application\Dto\Competitor;

use App\Domain\Competitor\Competitor;

final class CompetitorDto
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}

    public static function fromEntity(Competitor $competitor): self
    {
        return new self(
            $competitor->getId()->toString(),
            $competitor->getName(),
        );
    }
}