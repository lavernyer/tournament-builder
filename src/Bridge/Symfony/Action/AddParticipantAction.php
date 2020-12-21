<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Action;

use App\Application\Dto\Tournament\ParticipantDto;
use App\Application\Exception\CompetitorNotFound;
use App\Application\Exception\TournamentNotFound;
use App\Application\Service\Tournament\AddParticipant;
use App\Application\Service\Tournament\AddParticipantService;
use App\Bridge\Symfony\Annotation\RequestParam;
use App\Bridge\Symfony\Annotation\ResponseBody;
use App\Domain\Competitor\CompetitorId;
use App\Domain\Tournament\TournamentId;
use App\Infrastructure\EventSauce\Doctrine\EventPublisher;
use EventSauce\EventSourcing\MessageDispatcher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class AddParticipantAction
{
    public function __construct(private AddParticipantService $service)
    {
    }

    #[Route('/tournaments/{tournamentId}/participants', methods: ['POST'])]
    #[ResponseBody]
    public function __invoke(
        string $tournamentId,
        #[RequestParam] string $competitorId
    ): ParticipantDto
    {
        try {
            return $this->service->execute(new AddParticipant(
                TournamentId::fromString($tournamentId),
                CompetitorId::fromString($competitorId)
            ));
        } catch (TournamentNotFound | CompetitorNotFound $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}