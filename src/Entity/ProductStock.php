<?php

namespace Roma\SyliusProductVariantPlugin\Entity;

use App\Entity\Product\Product;
use Roma\SyliusProductVariantPlugin\Repository\ProductStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: ProductStockRepository::class)]
class ProductStock implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $stockStatus;

    #[ORM\OneToOne(targetEntity: Product::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $restockDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockStatus(): ?int
    {
        return $this->stockStatus;
    }

    public function setStockStatus(?int $stockStatus): self
    {
        $this->stockStatus = $stockStatus;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getRestockDate(): ?\DateTimeInterface
    {
        return $this->restockDate;
    }

    public function setRestockDate(?\DateTimeInterface $restockDate): self
    {
        $this->restockDate = $restockDate;

        return $this;
    }
}
