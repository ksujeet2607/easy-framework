<?php

namespace Library\Middleware;

use Library\Exceptions\CSRFValidationException;
use Library\Http\Request;
use Library\Http\Response;
use Library\Security\SecurityService;

class CsrfMiddleware implements MiddlewareInterface
{
    public function __construct(private SecurityService $securityService)
    {
    }

    public function process(Request $request, Response $response, callable $next): Response
    {
        $method = strtoupper($request->getMethod());
        $uri = $request->getUri();

        // Skip CSRF validation for excluded methods
        if (in_array($method, $this->securityService->getExcludedMethods(), true) ||
            in_array($uri, $this->securityService->getExcludedRoutes(), true)) {
            return $next($request, $response);
        }

        // Perform CSRF validation
        if (!$this->securityService->validate($method, $uri, $request)) {
//            var_dump([
//                'session_token' => $_SESSION['EASY_CSRF_TOKEN_SESS_IDX'] ?? null,
//                'session_time'  => $_SESSION['EASY_CSRF_TOKEN_TIME'] ?? null,
//                'current_time'  => time(),
//                'difference'    => time() - ($_SESSION['EASY_CSRF_TOKEN_TIME'] ?? 0),
//                'posted_token'  => $_POST['easy-csrf-token'] ?? null,
//            ]);
            throw new CSRFValidationException();
        }

        return $next($request, $response);
    }

}
