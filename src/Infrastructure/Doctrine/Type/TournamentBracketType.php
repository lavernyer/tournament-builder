<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Tournament\TournamentBracket;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class TournamentBracketType extends StringType
{
    public const NAME = 'tournament_bracket';
    private const LENGTH = 32;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL(['length' => self::LENGTH]);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getTypeClass(): string
    {
        return TournamentBracket::class;
    }
}