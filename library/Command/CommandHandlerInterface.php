<?php

namespace Library\Command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): mixed;
}