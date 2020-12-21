<?php

use App\Infrastructure\EventSauce\Dispatcher\SymfonyDispatcher;
use App\Infrastructure\EventSauce\Doctrine\EventPublisher;
use EventSauce\EventSourcing\MessageDispatcher;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;

return static function (ContainerConfigurator $configurator, Kernel $kernel): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire();

    $services->load('App\\', __DIR__ . '/../src');
    $services
        ->load('App\\Bridge\\Symfony\\Action\\', __DIR__ . '/../src/Bridge/Symfony/Action')
        ->tag('controller.service_arguments');

    $services->set(EventPublisher::class)
        ->tag('doctrine.event_subscriber')
    ;

    $services->alias(MessageDispatcher::class, SymfonyDispatcher::class);

    $configurator->import(__DIR__ . '/services/draw.php');
    $configurator->import(__DIR__ . '/services/competitor.php');
    $configurator->import(__DIR__ . '/services/tournament.php');
    $configurator->import(__DIR__ . '/services/workflow.php');
};
