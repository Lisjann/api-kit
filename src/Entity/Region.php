<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'region')]
#[ORM\Entity]
class Region
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[JMS\Groups(['region-id'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 140, nullable: false)]
    private string $name;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 10, unique: true, nullable: false)]
    #[JMS\Groups(['price-region-info'])]
    private string $code;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

//    #[ORM\OneToMany(mappedBy: 'region', targetEntity: 'Price')]
//    private Collection $prices;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): string
    {
      return $this->code;
    }

    public function setCode(string $code): void
    {
      $this->code = $code;
    }

    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }

//    public function addPrice(Price $price): void
//    {
//      if (!$this->prices->contains($price)) {
//        $this->prices->add($price);
//      }
//    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}
