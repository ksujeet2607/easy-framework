<?php

namespace Library\Facades;

use Library\Support\Facade;

/**
 * @mixin \Library\Utilities\View
 */
class View extends Facade
{

    /**
     * @inheritDoc
     */
    protected static function accessor(): string
    {
        return \Library\Utilities\View::class;
    }
}