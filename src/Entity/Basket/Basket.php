<?php

namespace App\Entity\Basket;

use App\Entity\User\User;
use App\Repository\Basket\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(mappedBy: 'basket', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: BasketLine::class)]
    private $basketLines;

    public function __construct()
    {
        $this->basketLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setBasket(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getBasket() !== $this) {
            $user->setBasket($this);
        }

        $this->user = $user;

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
            $basketLine->setBasket($this);
        }

        return $this;
    }

    public function removeBasketLine(BasketLine $basketLine): self
    {
        if ($this->basketLines->removeElement($basketLine)) {
            // set the owning side to null (unless already changed)
            if ($basketLine->getBasket() === $this) {
                $basketLine->setBasket(null);
            }
        }

        return $this;
    }

    public function getBasketTotal(): float
    {
        $total = 0;
        /** @var BasketLine $basketLine */
        foreach ($this->basketLines as $basketLine) {
            $total += $basketLine->getProduct()->first()->getPrice() * $basketLine->getQuantity();
        }
        return $total;
    }

    public function getBasketLineForProduct(int $productId): BasketLine|null
    {
        /** @var BasketLine $basketLine */
        foreach ($this->basketLines as $basketLine) {
            if ($basketLine->getProduct()->first()->getId() === $productId) {
                return $basketLine;
            }
        }
        return null;
    }
}
