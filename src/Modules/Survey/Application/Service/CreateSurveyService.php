<?php

declare(strict_types=1);

namespace App\Modules\Survey\Application\Service;

use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyCommand;
use App\Modules\Survey\Application\Command\UseCase\Survey\CreateSurvey\CreateSurveyCommandInput;
use App\Modules\Survey\Domain\Entity\Survey;
use App\Shared\Exception\ValidationFailedException;
use App\SharedKernel\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateSurveyService
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly CommandBus $commandBus,
    ) {
    }

    /**
     * @throws ValidationFailedException
     */
    public function process(CreateSurveyCommandInput $input): Survey
    {
        $violations = $this->validator->validate($input);
        if ($violations->count()) {
            throw new ValidationFailedException($violations);
        }

        $envelope = $this->commandBus->dispatch(new CreateSurveyCommand($input));

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
