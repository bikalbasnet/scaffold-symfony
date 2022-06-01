<?php

namespace App\Modules\Coupon\Response;

use Symfony\Component\HttpFoundation\Response;

class CouponCreatedResponse extends Response
{
    public function __construct()
    {
        parent::__construct(status: 201);
    }
}
