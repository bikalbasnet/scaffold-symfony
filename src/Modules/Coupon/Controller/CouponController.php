<?php

namespace App\Modules\Coupon\Controller;

use App\Modules\Coupon\Domain\Action\CreateCouponAction;
use App\Modules\Coupon\Domain\Action\FetchCouponAction;
use App\Modules\Coupon\Request\CreateCouponInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Modules\Coupon\Response\CouponCreatedResponse;

#[Route('/api/coupon')]
class CouponController extends AbstractController
{
    #[Route('/v1/create', methods: ['POST'])]
    /**
     * @OA\Tag(name="Coupon")
     * @OA\RequestBody(@Model(type=CreateCouponInput::class))
     * @OA\Response(
     *     response=200,
     *     description="Coupon Created",
     *     @Model(type=CouponCreatedResponse::class, groups={"public"})
     * )
     * @OA\Response(
     *     response=422,
     *     description="Validation Error"
     * )
     */
    public function createCoupon(
        CreateCouponInput   $input,
        CreateCouponAction $createCouponAction
    ): CouponCreatedResponse
    {
        $createCouponAction->create($input);

        return new CouponCreatedResponse();
    }
}
