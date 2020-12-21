<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Infrastructure\Doctrine\Model\EnumTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static self SIGNUP
 * @method static self ADJUSTMENT
 * @method static self ONGOING
 * @method static self FINISHED
 */
final class TournamentStatus extends Enum
{
    use EnumTrait;

    private const SIGNUP = 'signup';
    private const ADJUSTMENT = 'adjustment';
    private const ONGOING = 'ongoing';
    private const FINISHED = 'finished';

    public function isSignUp(): bool
    {
        return self::SIGNUP === $this->value;
    }

    public function isAdjustment(): bool
    {
        return self::ADJUSTMENT === $this->value;
    }

    public function isOngoing(): bool
    {
        return self::ONGOING === $this->value;
    }

    public function isFinished(): bool
    {
        return self::FINISHED === $this->value;
    }
}