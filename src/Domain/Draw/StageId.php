<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use App\Infrastructure\EventSauce\AggregateRootIdTrait;
use EventSauce\EventSourcing\AggregateRootId;

final class StageId implements AggregateRootId
{
    use AggregateRootIdTrait;
}