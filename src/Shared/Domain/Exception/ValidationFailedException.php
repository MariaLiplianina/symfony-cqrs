<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationFailedException extends \Exception
{
    private ConstraintViolationList $violationList;

    public function __construct(ConstraintViolationList $violationList)
    {
        parent::__construct((string) $violationList);
        $this->violationList = $violationList;
    }

    public function getViolationList(): ConstraintViolationList
    {
        return $this->violationList;
    }
}
