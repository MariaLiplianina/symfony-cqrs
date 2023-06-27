<?php

declare(strict_types=1);

namespace App\Modules\Survey\UI\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseController extends AbstractController
{

    protected function jsonError(string $message, int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $errors['message'] = $message;

        return new JsonResponse($errors, $status);
    }

    public function jsonValidationError(ConstraintViolationList $violations): JsonResponse
    {
        if (!$violations->count()) {
            throw new LogicException('ConstraintViolationList must not be empty');
        }

        $errors = [];
        foreach ($violations as $item) {
            $errors['validation'][$item->getPropertyPath()] = $item->getMessage();
        }

        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }
}
