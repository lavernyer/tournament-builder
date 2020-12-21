<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSauce\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;

final class EventPublisher implements EventSubscriber
{
    private MessageDispatcher $dispatcher;

    public function __construct(MessageDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $this->persistEvents($event->getEntity());
    }

    public function postUpdate(LifecycleEventArgs $event): void
    {
        $this->persistEvents($event->getEntity());
    }

    public function postRemove(LifecycleEventArgs $event): void
    {
        $this->persistEvents($event->getEntity());
    }

    private function persistEvents(object $entity): void
    {
        if (!$entity instanceof AggregateRoot) {
            return;
        }

        $messages = array_map(
            static fn(object $event) => new Message($event),
            $entity->releaseEvents()
        );

        $this->dispatcher->dispatch(...$messages);
    }
}
