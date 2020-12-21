<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder;

use App\Domain\Draw\Builder\Struct\TournamentStruct;
use Psr\Container\ContainerInterface;

final class TournamentRegistry
{
    private ContainerInterface $container;
    private array $brackets = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getTournamentBracket(string $bracketClass): TournamentStruct
    {
        if (array_key_exists($bracketClass, $this->brackets)) {
            return $this->brackets[$bracketClass];
        }

        return $this->brackets[] = $this->container->get($bracketClass);
    }
}
