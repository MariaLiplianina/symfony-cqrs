<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Bus;

use Symfony\Component\Messenger\Envelope;

interface QueryBus
{
    public function dispatch(Query $query): Envelope;
}
