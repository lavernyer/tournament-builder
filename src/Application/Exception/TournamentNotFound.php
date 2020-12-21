<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Tournament\TournamentId;
use RuntimeException;

final class TournamentNotFound extends RuntimeException
{
    public static function withId(TournamentId $id): self
    {
        return new self("Tournament with id {$id->toString()} was not found.");
    }
}