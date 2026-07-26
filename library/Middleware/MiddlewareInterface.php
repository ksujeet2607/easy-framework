<?php

namespace Library\Middleware;


use Library\Http\Request;
use Library\Http\Response;

interface MiddlewareInterface
{

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return \Library\Http\Response
     */
    public function process(Request $request, Response $response, callable $next): Response;
}