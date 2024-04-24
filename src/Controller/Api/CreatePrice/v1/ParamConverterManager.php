<?php

namespace App\Controller\Api\CreatePrice\v1;

use App\Controller\Api\CreatePrice\v1\Input\CreateImportPriceDTO;
use App\Controller\Api\CreatePrice\v1\Input\RegionDTO;
use App\Entity\Traits\SafeLoadFieldsTrait;


class ParamConverterManager
{
    public function setCreateImportPriceDTO($importPrice): CreateImportPriceDTO
    {
        /** @var SafeLoadFieldsTrait $createImportPriceDTO */
        $createImportPriceDTO = new CreateImportPriceDTO();
        $createImportPriceDTO->loadFromArray($importPrice);

        return $createImportPriceDTO;
    }

  public function setRegionDTO($prices): RegionDTO
  {
      /** @var SafeLoadFieldsTrait $pricesDTO */
      $regionDTO = new RegionDTO();
      $regionDTO->loadFromArray($prices);

      return $regionDTO;
  }
}
