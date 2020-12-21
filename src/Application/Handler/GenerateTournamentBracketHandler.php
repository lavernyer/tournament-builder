<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Draw\Builder\BracketFactory;
use App\Domain\Draw\StageRepository;
use App\Domain\Tournament\Event\TournamentSignupCompleted;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateTournamentBracketHandler implements MessageHandlerInterface
{
    public function __construct(
        private BracketFactory $bracketFactory,
        private StageRepository $stages,
    ){}

    public function __invoke(TournamentSignupCompleted $event): void
    {
        $stages = $this->bracketFactory->create($event->getTournamentId());

        $this->stages->addMulti(...$stages);
    }
}