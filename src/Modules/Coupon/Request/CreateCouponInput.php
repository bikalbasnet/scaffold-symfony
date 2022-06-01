<?php

namespace App\Modules\Coupon\Request;

use App\Infrastructure\ParamConverter\RequestDataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCouponInput implements RequestDataTransferObject
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public string $code;

    #[Assert\NotBlank]
    public string $name;

    public string $summary;

    #[Assert\Choice(
        choices: ['absolute', 'percentage'],
        message: 'Coupon type can be absolute or percentage',
    )]
    public string $type;

    #[Assert\Type('float')]
    #[Assert\Expression(
        "(this.type == 'percentage' and this.value > 0 and this.value < 100) or this.type == 'absolute'",
        message: 'Value must be between 0 and 100 for percentage',
    )]
    public float $value;

    #[Assert\Valid]
    public Criteria $criteria;
}
