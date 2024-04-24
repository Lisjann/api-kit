<?php

namespace App\Controller\Api\CreatePrice\v1;

use App\Controller\Common\ErrorResponseTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ImportPriceAction extends AbstractFOSRestController
{
    use ErrorResponseTrait;

    public function __construct(
      private readonly ImportPriceManager    $importPriceManager,
      private readonly ParamConverterManager $paramConverterManager
    ){
    }

    #[Rest\Post(path: '/api/v1/import-prices')]
    public function savePriceAction(Request $request): Response
    {
        return $this->handleView(
            $this->view($this->importPriceManager->saveImportPrice($request->getContent()),
            200));
    }
}
