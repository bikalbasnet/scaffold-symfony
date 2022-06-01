<?php

namespace App\Modules\Coupon\Persistence\Entity;

use App\Modules\Coupon\Persistence\Repository\CouponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', length: 11)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $code;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $summary;

    #[ORM\Column(type: 'string', length: 10)]
    private string $type;

    #[ORM\Column(type: 'integer', length: 11)]
    private float $value;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTimeInterface $start_date;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTimeInterface $end_date;

    #[ORM\Column(type: 'integer', length: 10, nullable: true)]
    private int $usage_limit;

    #[ORM\Column(type: 'integer', length: 10, nullable: true)]
    private int $order_min_amount;

    #[ORM\Column(type: 'integer', length: 10, nullable: true)]
    private int $order_max_amount;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: "create")]
    private \DateTimeInterface $created_date;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: "update")]
    private \DateTimeInterface $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReductionValue(): ?float
    {
        return $this->reduction_value;
    }

    public function setReductionValue(float $reduction_value): self
    {
        $this->reduction_value = $reduction_value;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getOrderMinAmount(): ?int
    {
        return $this->order_min_amount;
    }

    public function setOrderMinAmount(int $order_min_amount): self
    {
        $this->order_min_amount = $order_min_amount;

        return $this;
    }

    public function getOrderMaxAmount(): ?int
    {
        return $this->order_max_amount;
    }

    public function setOrderMaxAmount(int $order_max_amount): self
    {
        $this->order_max_amount = $order_max_amount;

        return $this;
    }

    public function getUsageLimit(): ?int
    {
        return $this->usage_limit;
    }

    public function setUsageLimit(int $usage_limit): self
    {
        $this->usage_limit = $usage_limit;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getNewCustomersOnly(): ?bool
    {
        return $this->new_customers_only;
    }

    public function setNewCustomersOnly(bool $new_customers_only): self
    {
        $this->new_customers_only = $new_customers_only;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getBlurb(): ?string
    {
        return $this->blurb;
    }

    public function setBlurb(string $blurb): self
    {
        $this->blurb = $blurb;

        return $this;
    }

    public function getActiveOnCampaign(): ?bool
    {
        return $this->active_on_campaign;
    }

    public function setActiveOnCampaign(bool $active_on_campaign): self
    {
        $this->active_on_campaign = $active_on_campaign;

        return $this;
    }

    public function getUsageLimitRestriction(): ?string
    {
        return $this->usage_limit_restriction;
    }

    public function setUsageLimitRestriction(?string $usage_limit_restriction): self
    {
        $this->usage_limit_restriction = $usage_limit_restriction;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSummary(): ?string
    {
        return stream_get_contents($this->summary);
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}
