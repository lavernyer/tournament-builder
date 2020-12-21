<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Infrastructure\EventSauce\AggregateRootIdTrait;
use EventSauce\EventSourcing\AggregateRootId;

final class TournamentId implements AggregateRootId
{
    use AggregateRootIdTrait;
}