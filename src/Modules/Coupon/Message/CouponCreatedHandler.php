<?php

namespace App\Modules\Coupon\Message;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CouponCreatedHandler
{
    public function __invoke(CouponCreated $coupon): void
    {
    }
}
