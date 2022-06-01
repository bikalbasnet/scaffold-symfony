<?php

namespace App\Infrastructure\ParamConverter;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestDTOValidationListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelController']
        ];
    }

    public function onKernelController(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof RequestDTOValidationException) {
            $response = $this->generateValidationErrorResponse($exception->getViolations());
            $event->setResponse($response);
        }

        if ($exception instanceof NotNormalizableValueException) {
            $event->setResponse($this->generateNotNormalizableErrorResponse());
        }
    }

    private function generateValidationErrorResponse(ConstraintViolationListInterface $errors): JsonResponse
    {
        $violations = [];
        foreach ($errors as $error) {
            $violations[$error->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse(['violations' => $violations], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function generateNotNormalizableErrorResponse(): JsonResponse
    {
        return new JsonResponse(['violations' => 'Invalid attribute'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
