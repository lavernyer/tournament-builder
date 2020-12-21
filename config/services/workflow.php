<?php

use App\Domain\Tournament\Tournament;
use App\Domain\Tournament\TournamentStatus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Workflow\WorkflowInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator, ContainerBuilder $containerBuilder): void {
    $services = $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire();

    $configurator->extension('framework', [
        'workflows' => [
            'tournament' => [
                'marking_store' => [
                    'type' => 'method',
                    'property' => 'status',
                ],
                'supports' => Tournament::class,
                'initial_marking' => TournamentStatus::SIGNUP()->toString(),
                'places' => array_values(TournamentStatus::toArray()),
                'transitions' => [
                    'adjustment' => [
                        'from' => TournamentStatus::SIGNUP()->toString(),
                        'to' => TournamentStatus::ADJUSTMENT()->toString(),
                    ],
                    'ongoing' => [
                        'from' => TournamentStatus::ADJUSTMENT()->toString(),
                        'to' => TournamentStatus::ONGOING()->toString(),
                    ],
                    'finished' => [
                        'from' => TournamentStatus::ONGOING()->toString(),
                        'to' => TournamentStatus::FINISHED()->toString(),
                    ],
                ],
            ],
        ],
    ]);

    $services->alias(WorkflowInterface::class . ' $tournamentWorkflow', service('state_machine.tournament'));
};
