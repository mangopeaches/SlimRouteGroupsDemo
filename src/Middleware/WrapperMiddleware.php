<?php
namespace SlimRouteGroupsDemo\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Demo of route level middleware.
 * @author Thomas Breese <thomasjbreese@gmail.com>
 */
class WrapperMiddleware
{
    /**
     * Invokes the middleware.
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        return $response;
    }
}
