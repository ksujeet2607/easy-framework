<?php

namespace Library\Middleware;

use Library\Http\Request;
use Library\Http\Response;

class ClearOldInputMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response
    {
        $response = $next($request, $response);

        // Clear after form has consumed it
        if ($request->getMethod() === 'GET') {
            clear_old_input();
            clear_error();
        }

        return $response;
    }
}

