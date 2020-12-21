<?php

declare(strict_types=1);

namespace App\Application\Dto\Tournament;

use App\Domain\Tournament\Participant;

final class ParticipantDto
{
    public function __construct(
        public string $competitorId,
        public string $name
    ) {}

    public static function fromEntity(Participant $winner): self
    {
        return new self(
            $winner->getCompetitorId()->toString(),
            $winner->getName(),
        );
    }
}