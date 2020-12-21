<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSauce;

use BadMethodCallException;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use Generator;

trait AggregateRootTrait
{
    private array $recordedEvents = [];

    public function aggregateRootId(): AggregateRootId
    {
        return $this->getId();
    }

    public function aggregateRootVersion(): int
    {
        return 0;
    }

    public function releaseEvents(): array
    {
        $releasedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $releasedEvents;
    }

    public static function reconstituteFromEvents(AggregateRootId $aggregateRootId, Generator $events): AggregateRoot
    {
        throw new BadMethodCallException('Method not implemented');
    }

    protected function recordThat(object $event): void
    {
        $this->recordedEvents[] = $event;
    }
}