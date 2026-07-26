<?php

namespace Library\Facades;

use Library\Support\Facade;

/**
 * @mixin \Library\Http\Request
 */
class Request extends Facade
{
    protected static function accessor(): string
    {
        return \Library\Http\Request::class;
    }
}
