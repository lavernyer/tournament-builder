<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSauce\Dispatcher;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class SymfonyDispatcher implements MessageDispatcher
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(Message ...$messages): void
    {
        foreach ($messages as $message) {
            $event = $message->event();

            try {
                $this->messageBus->dispatch($event);
            } catch (HandlerFailedException $e) {
                while ($e instanceof HandlerFailedException) {
                    /** @var Throwable $e */
                    $e = $e->getPrevious();
                }

                throw $e;
            }
        }
    }
}
