<?php

namespace App\Controller\Common;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ErrorResponseTrait
{
    private function createValidationErrorArray(ConstraintViolationListInterface $validationErrors)
    {
        $errors = [];

        foreach ($validationErrors as $error) {
          /** @var ConstraintViolationInterface $error */
          $errors[] = $this->createCustomValidationErrorArray($error->getPropertyPath(), $error->getMessage());
        }

        return $errors;
    }

    private function createCustomValidationErrorArray($propertyPath, $message): Error
    {
        return new Error($propertyPath, $message);
    }
}
