<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Bus;

use Symfony\Component\Messenger\Envelope;

interface CommandBus
{
    public function dispatch(Command|AsyncCommand $command): Envelope;
}
