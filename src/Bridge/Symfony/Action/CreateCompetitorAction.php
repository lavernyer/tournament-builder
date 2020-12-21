<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Action;

use App\Application\Dto\Competitor\CreateCompetitorDto;
use App\Application\Dto\Competitor\CompetitorDto;
use App\Application\Service\Competitor\CreateCompetitor;
use App\Application\Service\Competitor\CreateCompetitorService;
use App\Bridge\Symfony\Annotation\RequestBody;
use App\Bridge\Symfony\Annotation\ResponseBody;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCompetitorAction
{
    public function __construct(private CreateCompetitorService $service)
    {}

    #[Route('/competitors', methods: ['POST'])]
    #[ResponseBody]
    public function __invoke(
        #[RequestBody] CreateCompetitorDto $competitor
    ): CompetitorDto
    {
        return $this->service->execute(new CreateCompetitor($competitor));
    }
}