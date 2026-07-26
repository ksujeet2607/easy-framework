<?php

namespace Library\Facades;

use Library\Session\SessionManager;
use Library\Support\Facade;

/**
 * @mixin SessionManager
 */
class Session extends Facade
{
    protected static function accessor(): string
    {
        return SessionManager::class;
    }
}
