<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use App\Entity\Traits\DoctrineEntityCreatedAtTrait;
use App\Entity\Traits\DoctrineEntityUpdatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'price')]
#[ORM\Index(columns: ['author_id'], name: 'price__author_id__ind')]
#[ORM\Index(columns: ['product_id'], name: 'price__product_id__ind')]
#[ORM\Index(columns: ['region_id'], name: 'price__region_id__ind')]
#[ORM\Entity(repositoryClass: PriceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Price implements HasMetaTimestampsInterface
{
    use DoctrineEntityCreatedAtTrait;
    use DoctrineEntityUpdatedAtTrait;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[JMS\Groups(['price-id'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'Product', inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[JMS\Groups(['price-info'])]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: 'Region', inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id')]
    #[JMS\Groups(['price-info'])]
    private Region $region;

    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id')]
    #[JMS\Groups(['price-info'])]
    private User $author;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 14, nullable: false)]
    #[JMS\Groups(['price-info'])]
    private string $pricePurchase;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 14, nullable: false)]
    #[JMS\Groups(['price-info'])]
    private string $priceSelling;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 14, nullable: false)]
    #[JMS\Groups(['price-info'])]
    private string $priceDiscount;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProduct(): Product
    {
      return $this->product;
    }

    public function setProduct(Product $product): void
    {
      $this->product = $product;
    }

    public function getRegion(): Region
    {
      return $this->region;
    }

    public function setRegion(Region $region): void
    {
      $this->region = $region;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getPricePurchase(): string
    {
        return $this->pricePurchase;
    }

    public function setPricePurchase(string $pricePurchase): void
    {
        $this->pricePurchase = $pricePurchase;
    }

    public function getPriceSelling(): string
    {
      return $this->priceSelling;
    }

    public function setPriceSelling(string $priceSelling): void
    {
      $this->priceSelling = $priceSelling;
    }

    public function getPriceDiscount(): string
    {
      return $this->priceDiscount;
    }

    public function setPriceDiscount(string $priceDiscount): void
    {
      $this->priceDiscount = $priceDiscount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->author->getLogin(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
