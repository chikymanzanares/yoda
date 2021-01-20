<?php

declare(strict_types=1);

namespace Inbenta\SharedKernel\Application\CommandBus;

interface CommandHandler
{
    public function __invoke(Command $command): void;
}
