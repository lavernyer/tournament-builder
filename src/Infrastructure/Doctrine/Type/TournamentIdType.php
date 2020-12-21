<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Tournament\TournamentId;

final class TournamentIdType extends UuidType
{
    public const NAME = 'tournament_id';

    protected function getTypeClass(): string
    {
        return TournamentId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}