<?php
namespace SlimRouteGroupsDemo\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Middleware to apply data element to incoming request object.
 * @author Thomas Breese <thomasjbreese@gmail.com>
 */
class AdditionalDataMiddleware
{
    /**
     * Invokes the middleware.
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $request = $request->withAttribute('AdditionalData', ['some' => 'data']);
        return $next($request, $response);
    }
}
