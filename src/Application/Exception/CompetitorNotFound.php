<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Competitor\CompetitorId;
use RuntimeException;

final class CompetitorNotFound extends RuntimeException
{
    public static function withId(CompetitorId $id): self
    {
        return new self("Competitor with id {$id->toString()} was not found.");
    }
}