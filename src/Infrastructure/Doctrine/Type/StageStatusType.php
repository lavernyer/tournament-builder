<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Draw\StageStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class StageStatusType extends StringType
{
    public const NAME = 'stage_status';
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
        return StageStatus::class;
    }
}