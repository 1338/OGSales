<?php

namespace App\Entity\Enchantments;

use App\Entity\Catalog\CatalogItem;
use App\Repository\Enchantments\EnchantmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnchantmentRepository::class)]
class Enchantment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: CatalogItem::class, mappedBy: 'enchantments')]
    private $catalogItems;

    public function __construct()
    {
        $this->catalogItems = new ArrayCollection();
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
     * @return Collection<int, CatalogItem>
     */
    public function getCatalogItems(): Collection
    {
        return $this->catalogItems;
    }

    public function addCatalogItem(CatalogItem $catalogItem): self
    {
        if (!$this->catalogItems->contains($catalogItem)) {
            $this->catalogItems[] = $catalogItem;
            $catalogItem->addEnchantment($this);
        }

        return $this;
    }

    public function removeCatalogItem(CatalogItem $catalogItem): self
    {
        if ($this->catalogItems->removeElement($catalogItem)) {
            $catalogItem->removeEnchantment($this);
        }

        return $this;
    }
}
