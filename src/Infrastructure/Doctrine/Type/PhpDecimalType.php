<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use Decimal\Decimal;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use TypeError;

final class PhpDecimalType extends Type
{
    public const NAME = 'php_decimal';

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Decimal) {
            return $value->toString();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'Decimal']);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Decimal
    {
        if (null === $value || $value instanceof Decimal) {
            return $value;
        }

        try {
            return new Decimal($value);
        } catch (TypeError) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['int', 'string']);
        }
    }
}
