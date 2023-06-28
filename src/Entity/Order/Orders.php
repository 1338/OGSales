<?php

namespace App\Entity\Order;

use App\Entity\User\User;
use App\Repository\Order\OrdersRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'mainOrder', targetEntity: OrderLine::class)]
    private $orderLines;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    private $user;

    #[ORM\ManyToOne(targetEntity: OrderStatus::class, inversedBy: 'orders')]
    private $status;

    #[ORM\ManyToOne(targetEntity: OrderDeliveryType::class, inversedBy: 'orders')]
    private $deliveryType;

    #[ORM\Column(type: 'date')]
    private $orderDate;

    #[ORM\ManyToOne(targetEntity: OrderDeadDrop::class, inversedBy: 'orders')]
    private $deadDrop;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->orderDate = new DateTime("now");
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
            $orderLine->setMainOrder($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getMainOrder() === $this) {
                $orderLine->setMainOrder(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeliveryType(): ?OrderDeliveryType
    {
        return $this->deliveryType;
    }

    public function setDeliveryType(?OrderDeliveryType $deliveryType): self
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOrderTotal(): float
    {
        $total = 0;
        /** @var OrderLine $orderLine */
        foreach ($this->getOrderLines() as $orderLine) {
            $total += $orderLine->getPrice();
        }
        return $total;
    }

    public function getDeadDrop(): ?OrderDeadDrop
    {
        return $this->deadDrop;
    }

    public function setDeadDrop(?OrderDeadDrop $deadDrop): self
    {
        $this->deadDrop = $deadDrop;

        return $this;
    }
}
