<?php

namespace App\Controller\Api\CreatePrice\v1\Input;

use App\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;

class CreateImportPriceDTO
{
    use SafeLoadFieldsTrait;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $product_id;

    #[Assert\NotBlank]
//    #[Assert\Type(pricesDTO::class)]
    #[Assert\Type('array')]
    public array $prices;

  public function getSafeFields(): array
    {
        return ['product_id', 'prices'];
    }
}
