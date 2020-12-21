<?php

declare(strict_types=1);

namespace App\Domain\Competitor;

use App\Infrastructure\EventSauce\AggregateRootIdTrait;
use EventSauce\EventSourcing\AggregateRootId;

final class CompetitorId implements AggregateRootId
{
    use AggregateRootIdTrait;
}