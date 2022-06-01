<?php

namespace App\Infrastructure\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDTOConverter implements ParamConverterInterface
{
    private Serializer $serializer;
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor(typeExtractors: [new PhpDocExtractor(), new ReflectionExtractor()]);

        $normalizers = [
            new DateTimeNormalizer(),
            new ArrayDenormalizer(),
            new ObjectNormalizer(
                nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                propertyTypeExtractor: $extractor
            ),
        ];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->validator = $validator;
    }

    /**
     * Creates DTO class from request data
     *
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     * @throws ExceptionInterface|RequestDTOValidationException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $data = $request->toArray();
        $class = $configuration->getClass();

        try {
            $dto = $this->getDto($data, $class);
        } catch (PartialDenormalizationException $e) {
            $violations = $this->getViolationFromNormalizedError($e);
            throw new RequestDTOValidationException($violations);
        }

        $request->attributes->set($configuration->getName(), $dto);

        $validationErrors = $this->validator->validate($dto);

        if ($validationErrors->count() > 0) {
            throw new RequestDTOValidationException($validationErrors);
        }

        return true;
    }

    /**
     * Only applies for object that implements RequestDataTransferObject
     *
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass())
        {
            return  false;
        }

        $implementedClasses = class_implements($configuration->getClass()) ?: [];
        if($implementedClasses[RequestDataTransferObject::class] ?? false) {
            return true;
        }

        return false;
    }

    /**
     * @param string[] $data
     * @param string $class
     * @return mixed
     * @throws ExceptionInterface|PartialDenormalizationException
     */
    private function getDto(array $data, string $class): mixed
    {
        return $this->serializer->denormalize($data, $class, 'json', [
            DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true
        ]);
    }

    /**
     * When denormalizing a payload to an object with typed properties, you'll get an exception if
     * the payload contains properties that don't have the same type as the object.
     * https://symfony.com/doc/current/components/serializer.html#collecting-type-errors-while-denormalizing
     *
     * @param PartialDenormalizationException $e
     * @return ConstraintViolationList
     */
    private function getViolationFromNormalizedError(PartialDenormalizationException $e):
    ConstraintViolationList
    {
        $violations = new ConstraintViolationList();

        /** @var NotNormalizableValueException $exception */
        foreach ($e->getErrors() as $exception) {
            $message = sprintf(
                'The type must be one of %s (%s given).',
                implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType()
            );

            $parameters = [];
            if ($exception->canUseMessageForUser()) {
                $parameters['hint'] = $exception->getMessage();
            }

            $violations->add(
                new ConstraintViolation(
                    $message,
                    '',
                    $parameters,
                    null,
                    $exception->getPath(),
                    null
                )
            );
        }

        return $violations;
    }
}
