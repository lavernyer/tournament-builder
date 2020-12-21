<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Competitor\CompetitorId;

final class CompetitorIdType extends UuidType
{
    public const NAME = 'competitor_id';

    protected function getTypeClass(): string
    {
        return CompetitorId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}