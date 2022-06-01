<?php

namespace App\Modules\Coupon\Persistence\Repository;

use App\Modules\Coupon\Persistence\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function saveCoupon(Coupon $coupon): void
    {
        $em = $this->getEntityManager();

        $em->persist($coupon);
        $em->flush();
    }
}
