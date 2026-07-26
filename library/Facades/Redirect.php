<?php

namespace Library\Facades;

use Library\Http\RedirectResponse;
use Library\Support\Facade;

/**
 * @mixin RedirectResponse
 */
class Redirect extends Facade
{

    /**
     * @inheritDoc
     */
    protected static function accessor(): string
    {
        return RedirectResponse::class;
    }
}