<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Attribute;
use Symfony\Component\HttpKernel\Attribute\ArgumentInterface;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestParam implements ArgumentInterface
{
}