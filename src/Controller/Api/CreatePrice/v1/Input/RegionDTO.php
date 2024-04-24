<?php

namespace App\Controller\Api\CreatePrice\v1\Input;

use App\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;

class RegionDTO
{
    use SafeLoadFieldsTrait;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $price_purchase;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $price_selling;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $price_discount;

    public function getSafeFields(): array
    {
        return ['price_purchase', 'price_selling', 'price_discount'];
    }
}
