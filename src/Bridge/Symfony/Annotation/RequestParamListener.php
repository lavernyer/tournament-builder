<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

final class RequestParamListener implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getAttribute() instanceof RequestParam;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            $request = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            yield $request[$argument->getName()];
        } catch (Throwable $e) {
            throw new BadRequestHttpException('Bad request parameter provided', $e);
        }
    }
}