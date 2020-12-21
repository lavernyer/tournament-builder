<?php

use App\Domain\Competitor\CompetitorRepository;
use App\Domain\Competitor\Factory\CompetitorFactory;
use App\Domain\Competitor\Factory\DefaultCompetitorFactory;
use App\Infrastructure\Doctrine\Repository\OrmCompetitorRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator, ContainerBuilder $containerBuilder): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire();

    $services->alias(CompetitorRepository::class, OrmCompetitorRepository::class);
    $services->alias(CompetitorFactory::class, DefaultCompetitorFactory::class);
};
