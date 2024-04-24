<?php

namespace App\Controller\Api\CreatePrice\v1;

use App\Controller\Api\CreatePrice\v1\Input\CreateImportPriceDTO;
use App\Controller\Api\CreatePrice\v1\Output\PriceCreatedDTO;
use App\Controller\Api\CreatePrice\v1\Input\RegionDTO;
use App\Controller\Common\ErrorResponseTrait;
use App\Entity\Price;
use App\Entity\Product;
use App\Entity\Region;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportPriceManager
{
    use ErrorResponseTrait;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        private readonly ParamConverterManager $paramConverterManager,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function saveImportPrice($json)
    {
        $content = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        foreach ($content as $item) {
            $createImportPriceDTO = $this->paramConverterManager->setCreateImportPriceDTO($item);

            $importPrice = $this->saveProductPrice($createImportPriceDTO);

            $data[] = $importPrice;
        }

        return $data;
    }

    public function saveProductPrice(CreateImportPriceDTO $createImportPriceDTO)
    {
        $results = [];

        $validationErrorsCreateImportPrice =  $this->createValidationErrorArray(
            $this->validator->validate($createImportPriceDTO)
        );

        if (count($validationErrorsCreateImportPrice)) {
            $results['error'][] = $validationErrorsCreateImportPrice;
            return $results;
        }

        $product = $this->entityManager->getRepository(Product::class)->find($createImportPriceDTO->product_id);

        if (!$product) {
            $results['error'][] = $this->createCustomValidationErrorArray(
                'product_id',
                'No product found for id '. $createImportPriceDTO->product_id
            );

            return $results;
        }

        foreach ($createImportPriceDTO->prices as $key => $prices) {

            $region = $this->entityManager->getRepository(Region::class)->findOneBy(['code' => $key]);

            if (!$region) {
                $results['error'][] =$this->createCustomValidationErrorArray(
                    'region_id',
                    'No region found for id '.$key
                );
                continue;
            }

            $regionDTO = $this->paramConverterManager->setRegionDTO($prices);

            $validationErrorsRegionDTO =  $this->createValidationErrorArray(
                $this->validator->validate($regionDTO)
            );

            if (count($validationErrorsRegionDTO)) {
                $results['error'][] = $validationErrorsRegionDTO;
                continue;
            }

            $result = new PriceCreatedDTO();
            $context = (new SerializationContext())->setGroups([
                'price-info',
                'price-id',
                'price-region-info',
                'price-product-info'
            ]);

            $result->loadFromJsonString(
                $this->serializer->serialize(
                    $this->savePrice($product, $region, $regionDTO),
                    'json',
                    $context
                )
            );

            $results['success'][] = $result;
        }

        return $results;
    }


    public function savePrice(Product $product, Region $region, RegionDTO $regionDTO): Price
    {
        /** @var UserRepository $userRepository */
        $priceRepository = $this->entityManager->getRepository(Price::class);
        $price = $priceRepository->getPrice($region, $product);

        if (!$price) {
            $price = new Price();
        }

        $price->setProduct($product);
        $price->setRegion($region);

        $price->setPricePurchase($regionDTO->price_purchase);
        $price->setPriceSelling($regionDTO->price_selling);
        $price->setPriceDiscount($regionDTO->price_discount);

        $this->entityManager->persist($price);
        $this->entityManager->flush();

        return $price;
    }
}
