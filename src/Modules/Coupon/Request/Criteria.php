<?php

namespace App\Modules\Coupon\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Criteria
{
    #[Assert\DateTime(\DateTimeInterface::RFC3339)]
    #[Assert\LessThan(propertyPath: "endDate")]
    #[Assert\NotBlank]
    public string $startDate;

    #[Assert\DateTime(\DateTimeInterface::RFC3339)]
    #[Assert\NotBlank]
    public string $endDate;

    #[Assert\Positive]
    #[Assert\NotBlank]
    public int $usageLimit;

    #[Assert\PositiveOrZero]
    #[Assert\LessThan(propertyPath: "orderMaxAmount")]
    #[Assert\NotBlank]
    public int $orderMinAmount;

    #[Assert\PositiveOrZero]
    #[Assert\NotBlank]
    public int $orderMaxAmount;
}
