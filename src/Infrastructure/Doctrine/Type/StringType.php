<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

abstract class StringType extends Type
{
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        try {
            return forward_static_call([$this->getTypeClass(), 'fromString'], $value);
        } catch (InvalidArgumentException) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return null === $value ? $value : (string)$value;
    }

    abstract protected function getTypeClass(): string;
}
