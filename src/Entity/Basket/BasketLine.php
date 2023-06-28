<?php

namespace App\Entity\Basket;

use App\Entity\Catalog\CatalogItem;
use App\Repository\Basket\BasketLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketLineRepository::class)]
class BasketLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Basket::class, inversedBy: 'basketLines')]
    private $basket;

    #[ORM\ManyToMany(targetEntity: CatalogItem::class, inversedBy: 'basketLines')]
    private $product;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): self
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * @return Collection<int, CatalogItem>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(CatalogItem $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(CatalogItem $product): self
    {
        $this->product->removeElement($product);

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

    public function __toString(): string
    {
        return sprintf('%s x %s', $this->quantity, $this->product->first());
    }
}
