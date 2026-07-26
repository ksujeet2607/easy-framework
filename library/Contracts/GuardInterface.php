<?php

namespace Library\Contracts;

use Library\Http\Request;

interface GuardInterface
{
    /**
     * Throw exception or return false to deny access
     */
    public function authorize(Request $request): void;
}