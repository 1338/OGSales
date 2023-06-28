<?php

namespace App\Entity\Catalog;

use App\Entity\Basket\BasketLine;
use App\Entity\Enchantments\Enchantment;
use App\Entity\Order\OrderLine;
use App\Repository\Catalog\CatalogItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogItemRepository::class)]
class CatalogItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: BasketLine::class, mappedBy: 'product')]
    private $basketLines;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 4)]
    private $price;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $stock = 0;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderLine::class)]
    private $orderLines;

    #[ORM\ManyToMany(targetEntity: Enchantment::class, inversedBy: 'catalogItems')]
    private $enchantments;

    public function __construct()
    {
        $this->basketLines = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
        $this->enchantments = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, BasketLine>
     */
    public function getBasketLines(): Collection
    {
        return $this->basketLines;
    }

    public function addBasketLine(BasketLine $basketLine): self
    {
        if (!$this->basketLines->contains($basketLine)) {
            $this->basketLines[] = $basketLine;
            $basketLine->addProduct($this);
        }

        return $this;
    }

    public function removeBasketLine(BasketLine $basketLine): self
    {
        if ($this->basketLines->removeElement($basketLine)) {
            $basketLine->removeProduct($this);
        }

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
        return sprintf('%s (%s)', $this->name, (float)$this->price);
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
            $orderLine->setProduct($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getProduct() === $this) {
                $orderLine->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enchantment>
     */
    public function getEnchantments(): Collection
    {
        return $this->enchantments;
    }

    public function addEnchantment(Enchantment $enchantment): self
    {
        if (!$this->enchantments->contains($enchantment)) {
            $this->enchantments[] = $enchantment;
        }

        return $this;
    }

    public function removeEnchantment(Enchantment $enchantment): self
    {
        $this->enchantments->removeElement($enchantment);

        return $this;
    }
}
