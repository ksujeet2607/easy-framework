<?php

namespace Library\Middleware;

use Library\Database\DatabaseInterface;
use Library\Http\Request;
use Library\Http\Response;
use Psr\Log\LoggerInterface;


class EnsureDatabaseMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly DatabaseInterface $database, private readonly LoggerInterface $logger)
    {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function process(Request $request, Response $response, callable $next): Response
    {
        if(!$this->database || $this->database instanceof \Library\Database\NullDatabase) {
            $response->setBody("Database connection is required but not available.")->setStatusCode(500);
            $this->logger->warning('Database connection is required but not available: ');
            return $response;
        }
        return $next($request, $response);
    }
}