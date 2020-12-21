<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Attribute;
use Symfony\Component\HttpKernel\Attribute\ArgumentInterface;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestBody implements ArgumentInterface
{
    public function __construct(
        private bool $validate = true,
        private array $groups = []
    ) {}

    public function isValidate(): bool
    {
        return $this->validate;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }
}