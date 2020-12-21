<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidListener implements EventSubscriberInterface
{
    public function __construct(private ValidatorInterface $validator)
    {}

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER_ARGUMENTS => 'onControllerArguments'];
    }

    public function onControllerArguments(ControllerArgumentsEvent $event)
    {
//        dd($event->getArguments());
    }
}