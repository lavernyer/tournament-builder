<?php

use App\Domain\Draw\Builder\BracketFactory;
use App\Domain\Draw\Builder\DefaultBracketFactory;
use App\Domain\Draw\Builder\Key\AlphabeticKeyGenerator;
use App\Domain\Draw\Builder\Key\KeyGenerator;
use App\Domain\Draw\Builder\Key\RandomKeyGenerator;
use App\Domain\Draw\Builder\Struct\EmptyTournamentStruct;
use App\Domain\Draw\Builder\Struct\EightQualifiersTournamentStruct;
use App\Domain\Draw\RoundFactory\AnotherEliminationRoundFactory;
use App\Domain\Draw\RoundFactory\FirstEliminationRoundFactory;
use App\Domain\Draw\RoundFactory\RoundFactory;
use App\Domain\Draw\RoundFactory\RoundRobinRoundFactory;
use App\Domain\Draw\StageFactory\AnotherEliminationStageFactory;
use App\Domain\Draw\StageFactory\ChainStageFactory;
use App\Domain\Draw\StageFactory\FirstEliminationStageFactory;
use App\Domain\Draw\StageFactory\RoundRobinStageFactory;
use App\Domain\Draw\StageFactory\StageFactory;
use App\Domain\Draw\StageRepository;
use App\Infrastructure\Doctrine\Repository\OrmStageRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $configurator, ContainerBuilder $containerBuilder): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire();

    $services->alias(StageRepository::class, OrmStageRepository::class);

    $services->alias(BracketFactory::class, DefaultBracketFactory::class);

    // Stage Factory
    $services
        ->set(RoundRobinStageFactory::class)
        ->tag('app.stage.factory');
    $services
        ->set(FirstEliminationStageFactory::class)
        ->tag('app.stage.factory');
    $services
        ->set(AnotherEliminationStageFactory::class)
        ->tag('app.stage.factory');

    $services->alias(StageFactory::class, ChainStageFactory::class);
    $services
        ->set(ChainStageFactory::class)
        ->arg(0, tagged_iterator('app.stage.factory'));

    $services->alias(RoundFactory::class . ' $roundRobinFactory', RoundRobinRoundFactory::class);
    $services->alias(RoundFactory::class . ' $firstEliminationFactory', FirstEliminationRoundFactory::class);
    $services->alias(RoundFactory::class . ' $anotherEliminationFactory', AnotherEliminationRoundFactory::class);

    // Name provider
    $services->alias(KeyGenerator::class, AlphabeticKeyGenerator::class);
    $services->alias(KeyGenerator::class . ' $randomGenerator', RandomKeyGenerator::class);
    $services
        ->set(AlphabeticKeyGenerator::class)
        ->share(false);

    // Builders
    $services->set(EmptyTournamentStruct::class)->public();
    $services->set(EightQualifiersTournamentStruct::class)->public();
};
