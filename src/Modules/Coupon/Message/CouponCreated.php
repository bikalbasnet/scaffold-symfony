<?php

namespace App\Modules\Coupon\Message;

use App\Modules\Coupon\Persistence\Entity\Coupon;

class CouponCreated
{
    private Coupon $coupon;

    /**
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
}
