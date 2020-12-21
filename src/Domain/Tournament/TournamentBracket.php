<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Draw\Builder\Struct\EightQualifiersTournamentStruct;
use App\Infrastructure\Doctrine\Model\EnumTrait;
use MyCLabs\Enum\Enum;

/**
 * @method static self CLASSIC
 */
final class TournamentBracket extends Enum
{
    use EnumTrait;

    private const CLASSIC = 'classic';

    private array $map = [
        self::CLASSIC => EightQualifiersTournamentStruct::class,
    ];

    public function config(): string
    {
        return $this->map[$this->value];
    }
}