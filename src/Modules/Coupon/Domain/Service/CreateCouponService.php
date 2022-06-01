<?php

namespace App\Modules\Coupon\Domain\Service;

use App\Modules\Coupon\Domain\CouponConstants;
use App\Modules\Coupon\Persistence\Entity\Coupon;
use App\Modules\Coupon\Persistence\Repository\CouponRepository;
use App\Modules\Coupon\Request\CreateCouponInput;

class CreateCouponService
{
    public function __construct(private readonly CouponRepository $couponRepository)
    {
    }

    public function createCoupon(CreateCouponInput $input): Coupon
    {
        $coupon = new Coupon();

        $coupon->setName($input->name);
        $coupon->setSummary($input->summary);
        $coupon->setType($input->type);
        $coupon->setStartDate(new \DateTime($input->criteria->startDate));
        $coupon->setEndDate(new \DateTime($input->criteria->endDate));

        $coupon->setUsageLimit($input->criteria->usageLimit);
        $coupon->setOrderMinAmount($input->criteria->orderMinAmount);
        $coupon->setOrderMaxAmount($input->criteria->orderMaxAmount);

        $this->couponRepository->saveCoupon($coupon);

        return $coupon;
    }
}
