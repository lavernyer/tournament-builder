<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use MyCLabs\Enum\Enum;

/**
 * @method static self ROUND_ROBIN
 * @method static self ELIMINATION
 */
final class StageType extends Enum
{
    private const ROUND_ROBIN = 'round_robin';
    private const ELIMINATION = 'elimination';

    public function isRoundRobin(): bool
    {
        return $this->value === self::ROUND_ROBIN;
    }

    public function isElimination(): bool
    {
        return $this->value === self::ELIMINATION;
    }
}