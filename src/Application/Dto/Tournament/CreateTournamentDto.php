<?php

declare(strict_types=1);

namespace App\Application\Dto\Tournament;

use App\Domain\Tournament\TournamentBracket;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

final class CreateTournamentDto
{
    #[NotBlank]
    #[Choice(callback: [TournamentBracket::class, 'toArray'])]
    public string $bracket;

    #[NotBlank]
    #[Range(min: 1)]
    public int $divisionCount;

    #[NotBlank]
    #[Range(min: 2)]
    public int $participantCount;

    #[NotBlank]
    #[Range(min: 1)]
    public int $qualifyCount;
}