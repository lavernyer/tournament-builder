<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Draw\StageId;

final class StageIdType extends UuidType
{
    public const NAME = 'stage_id';

    protected function getTypeClass(): string
    {
        return StageId::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}