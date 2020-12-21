<?php

declare(strict_types=1);

namespace App\Domain\Matchup;

use App\Infrastructure\Doctrine\Model\EnumTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static self UPCOMING
 * @method static self FINISHED
 */
final class MatchupStatus extends Enum
{
    use EnumTrait;

    private const UPCOMING = 'upcoming';
    private const FINISHED = 'finished';
}