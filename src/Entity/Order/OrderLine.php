<?php

namespace App\Entity\Order;

use App\Entity\Catalog\CatalogItem;
use App\Repository\Order\OrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Orders::class, inversedBy: 'orderLines')]
    private $mainOrder;

    #[ORM\ManyToOne(targetEntity: CatalogItem::class, inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4)]
    private $priceUnit;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4)]
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainOrder(): ?Orders
    {
        return $this->mainOrder;
    }

    public function setMainOrder(?Orders $mainOrder): self
    {
        $this->mainOrder = $mainOrder;

        return $this;
    }

    public function getProduct(): ?CatalogItem
    {
        return $this->product;
    }

    public function setProduct(?CatalogItem $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPriceUnit(): ?string
    {
        return $this->priceUnit;
    }

    public function setPriceUnit(string $priceUnit): self
    {
        $this->priceUnit = $priceUnit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%d %s x %s', $this->id, $this->quantity, $this->product);
    }
}
