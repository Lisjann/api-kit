<?php

namespace App\Controller\Api\CreatePrice\v1\Output;

use App\Entity\Product;
use App\Entity\Region;
use App\Entity\Traits\SafeLoadFieldsTrait;

class PriceCreatedDTO
{
    use SafeLoadFieldsTrait;

    public int $id;

    public array $product;

    public array $region;

    public int $price_purchase;

    public int $price_selling;

    public int $price_discount;

    public function getSafeFields(): array
    {

        return ['id', 'product', 'region', 'price_purchase','price_selling','price_discount'];
    }
}
