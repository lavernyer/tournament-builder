<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Action;

use App\Application\Dto\Tournament\CreateTournamentDto;
use App\Application\Dto\Tournament\TournamentDto;
use App\Application\Service\Tournament\CreateTournament;
use App\Application\Service\Tournament\CreateTournamentService;
use App\Bridge\Symfony\Annotation\RequestBody;
use App\Bridge\Symfony\Annotation\ResponseBody;
use App\Domain\Draw\RoundFactory\RoundFactory;
use Symfony\Component\Routing\Annotation\Route;

final class CreateTournamentAction
{
    public function __construct(private CreateTournamentService $service)
    {}

    #[Route('/tournaments', methods: ['POST'])]
    #[ResponseBody]
    public function __invoke(
        #[RequestBody] CreateTournamentDto $tournament
    ): TournamentDto
    {
        return $this->service->execute(new CreateTournament($tournament));
    }
}