<?php

declare(strict_types=1);

namespace App\Domain\Draw;

use MyCLabs\Enum\Enum;

/**
 * @method static self FUTURE
 * @method static self ONGOING
 * @method static self FINISHED
 */
final class StageStatus extends Enum
{
    private const FUTURE = 'future';
    private const ONGOING = 'ongoing';
    private const FINISHED = 'finished';
}