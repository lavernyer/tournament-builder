<?php

declare(strict_types=1);

namespace App\Bridge\Symfony\Annotation;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseBodyListener implements EventSubscriberInterface
{
    private const CONTENT_TYPE = 'json';
    private const METHOD_TO_CODE = [
        'POST' => Response::HTTP_CREATED,
    ];

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => 'onKernelView'];
    }

    public function onKernelView(ViewEvent $event): void
    {
        $responseMapping = $this->hasResponseMapping($event);
        if (null === $responseMapping) {
            return;
        }

        $context = $responseMapping->getGroups() ? ['groups' => $responseMapping->getGroups()] : [];

        $json = $this->serializer->serialize($event->getControllerResult(), self::CONTENT_TYPE, $context);
        $code = self::METHOD_TO_CODE[$event->getRequest()->getMethod()] ?? Response::HTTP_OK;

        $event->setResponse(JsonResponse::fromJsonString($json, $code)->setEncodingOptions(JSON_UNESCAPED_UNICODE));
    }

    private function hasResponseMapping(ViewEvent $event): ?ResponseBody
    {
        $controllerName = $event->getRequest()->attributes->get('_controller');
        $controller = new ReflectionClass($controllerName);
        try {
            $method = $controller->getMethod('__invoke');
        } catch (ReflectionException) {
            return null;
        }

        foreach ($method->getAttributes() as $attribute) {
            if ($attribute->getName() === ResponseBody::class) {
                return $attribute->newInstance();
            }
        }

        return null;
    }
}