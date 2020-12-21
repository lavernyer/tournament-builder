<?php

declare(strict_types=1);

namespace App\Domain\Draw\StageFactory;

use App\Domain\Draw\Builder\Node\StageNode;
use App\Domain\Draw\Stage;
use App\Domain\Tournament\TournamentId;
use DomainException;

final class ChainStageFactory implements StageFactory
{
    /**
     * @var StageFactory[]
     */
    private array $factories = [];

    public function __construct(iterable $factories)
    {
        foreach ($factories as $factory) {
            $this->factories[] = $factory;
        }
    }

    public function create(StageNode $request, TournamentId $tournamentId, array $participants): Stage
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($request)) {
                return $factory->create($request, $tournamentId, $participants);
            }
        }

        throw new DomainException('Neither factory can handle request');
    }

    public function supports(StageNode $request): bool
    {
        return true;
    }
}