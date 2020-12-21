<?php

namespace App;

use App\Infrastructure\Doctrine\Type\CompetitorIdType;
use App\Infrastructure\Doctrine\Type\StageIdType;
use App\Infrastructure\Doctrine\Type\StageStatusType;
use App\Infrastructure\Doctrine\Type\TournamentBracketType;
use App\Infrastructure\Doctrine\Type\TournamentIdType;
use App\Infrastructure\Doctrine\Type\TournamentStatusType;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/services.yaml')) {
            $container->import('../config/services.yaml');
            $container->import('../config/{services}_'.$this->environment.'.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/routes.yaml')) {
            $routes->import('../config/routes.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

     protected function build(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('doctrine', [
            'dbal' => [
                'types' => [
                    TournamentIdType::NAME => TournamentIdType::class,
                    TournamentBracketType::NAME => TournamentBracketType::class,
                    TournamentStatusType::NAME => TournamentStatusType::class,
                    StageIdType::NAME => StageIdType::class,
                    StageStatusType::NAME => StageStatusType::class,
                    CompetitorIdType::NAME => CompetitorIdType::class,
                ],
            ],
        ]);
    }
}
