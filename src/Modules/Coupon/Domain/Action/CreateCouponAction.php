<?php

namespace App\Modules\Coupon\Domain\Action;

use App\Modules\Coupon\Domain\Service\CreateCouponService;
use App\Modules\Coupon\Message\CouponCreated;;

use App\Modules\Coupon\Request\CreateCouponInput;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateCouponAction
{
    public function __construct(
        private readonly EntityManagerInterface         $entityManager,
        private readonly CreateCouponService            $createCouponService,
        private readonly MessageBusInterface            $bus,
    )
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception|\Exception
     */
    public function create(CreateCouponInput $input): bool
    {
        $coupon = $this->createCouponService->createCoupon($input);
        $this->entityManager->commit();
        $this->bus->dispatch(new CouponCreated($coupon));

        return true;
    }
}
