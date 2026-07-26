<?php

namespace Library\Routes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class RouteGroup
{
    public function __construct(
        public string $prefix = '',
        public array $middlewares = []
    ){}

}