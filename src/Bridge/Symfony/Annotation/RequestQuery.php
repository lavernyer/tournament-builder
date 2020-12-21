<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Attribute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpKernel\Attribute\ArgumentInterface;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestQuery implements ArgumentInterface
{
    private array $groups;

    public function __construct(array $data = [])
    {
        $this->groups = $data['groups'] ?? [];
    }

    public function groups(): array
    {
        return $this->groups;
    }

    public function getAliasName(): string
    {
        return 'request_body';
    }

    public function allowArray(): bool
    {
        return false;
    }
}