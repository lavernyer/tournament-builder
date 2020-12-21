<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

final class RequestQueryListener implements ArgumentValueResolverInterface
{
    private const CONTENT_TYPE = 'json';

    public function __construct(
        private SerializerInterface $serializer
    ) {}

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getAttribute() instanceof RequestBody;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
            $normalizer = new ObjectNormalizer(null, null, null, $extractor);
            $serializer = new Serializer([new DateTimeNormalizer(), new ArrayDenormalizer(), $normalizer], ['json' => new JsonEncoder()]);

            yield $serializer->denormalize($request->query->all(), $argument->getType(), context: [
                'groups' => $argument->getAttribute()?->getGroups(),
            ]);
        } catch (Throwable) {
            throw new UnprocessableEntityHttpException('Invalid json.');
        }
    }
}