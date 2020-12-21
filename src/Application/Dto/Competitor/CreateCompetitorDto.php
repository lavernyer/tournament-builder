<?php

declare(strict_types=1);

namespace App\Application\Dto\Competitor;

use Symfony\Component\Validator\Constraints\NotBlank;

final class CreateCompetitorDto
{
    #[NotBlank]
    public string $name;
}