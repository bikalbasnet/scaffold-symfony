<?php

namespace App\Infrastructure\ParamConverter;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestDTOValidationException extends \Exception
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        parent::__construct("Validation Error");
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
