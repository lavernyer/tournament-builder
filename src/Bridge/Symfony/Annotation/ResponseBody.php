<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class ResponseBody
{
    public function __construct(private array $groups = [])
    {}

    public function getGroups(): array
    {
        return $this->groups;
    }
}