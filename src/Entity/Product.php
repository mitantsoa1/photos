<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, ProductPhotos>
     */
    #[ORM\OneToMany(targetEntity: ProductPhotos::class, mappedBy: 'productId')]
    private Collection $productPhotos;

    public function __construct()
    {
        $this->productPhotos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, ProductPhotos>
     */
    public function getProductPhotos(): Collection
    {
        return $this->productPhotos;
    }

    public function addProductPhoto(ProductPhotos $productPhoto): static
    {
        if (!$this->productPhotos->contains($productPhoto)) {
            $this->productPhotos->add($productPhoto);
            $productPhoto->setProductId($this);
        }

        return $this;
    }

    public function removeProductPhoto(ProductPhotos $productPhoto): static
    {
        if ($this->productPhotos->removeElement($productPhoto)) {
            // set the owning side to null (unless already changed)
            if ($productPhoto->getProductId() === $this) {
                $productPhoto->setProductId(null);
            }
        }

        return $this;
    }
}
