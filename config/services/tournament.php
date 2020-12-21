<?php

use App\Domain\Tournament\Factory\DefaultTournamentFactory;
use App\Domain\Tournament\Factory\TournamentFactory;
use App\Domain\Tournament\TournamentRepository;
use App\Infrastructure\Doctrine\Repository\OrmTournamentRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator, ContainerBuilder $containerBuilder): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire();

    $services->alias(TournamentRepository::class, OrmTournamentRepository::class);
    $services->alias(TournamentFactory::class, DefaultTournamentFactory::class);
};
