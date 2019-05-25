<?php
namespace SlimRouteGroupsDemo\Controllers;

use Slim\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Controller for user request processing.
 * @author Thomas Breese <thomasjbreese@gmail.com>
 */
class UserController
{
    /**
     * Instance of Slim Container.
     * @var Container
     */
    protected $container;

    /**
     * Instantiate a new instance.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Returns all users.
     * @param Request $request
     * @param Response $response
     * @param array $params
     * @return Response
     */
    public function getAllUsers(Request $request, Response $response, array $params)
    {
        $users = [
            ['id' => 1, 'firstName' => 'John', 'lastName' => 'Smith', 'email' => 'john@smith.com'],
            ['id' => 2, 'firstName' => 'Bob', 'lastName' => 'Dole', 'email' => 'bob@dole.com']
        ];
        return $response->withJson($users);
    }

    /**
     * Returns all users with additional data.
     * @param Request $request
     * @param Response $response
     * @param array $params
     * @return Response
     */
    public function getAllUsersWithData(Request $request, Response $response, array $params)
    {
        $users = [
            ['id' => 1, 'firstName' => 'John', 'lastName' => 'Smith', 'email' => 'john@smith.com'],
            ['id' => 2, 'firstName' => 'Bob', 'lastName' => 'Dole', 'email' => 'bob@dole.com']
        ];
        $additionalData = $request->getAttribute('AdditionalData');
        if ($additionalData) {
            $users[] = $additionalData;
        }
        return $response->withJson($users);
    }

    /**
     * Returns single user.
     * @param Request $request
     * @param Response $response
     * @param array $params
     * @return Response
     */
    public function getUser(Request $request, Response $response, array $params)
    {
        $userId = $params['userId'];
        $users = [
            ['id' => 1, 'firstName' => 'John', 'lastName' => 'Smith', 'email' => 'john@smith.com'],
            ['id' => 2, 'firstName' => 'Bob', 'lastName' => 'Dole', 'email' => 'bob@dole.com']
        ];
        $matchedUser = array_filter($users, function($user) use ($userId) {
            return $user['id'] == $userId;
        });
        if (!$matchedUser) {
            return $response->withStatus(404)->withJson(['error' => 'User not found.']);
        }
        return $response->withJson($matchedUser[0]);
    }

    /**
     * Returns single user attribute.
     * @param Request $request
     * @param Response $response
     * @param array $params
     * @return Response
     */
    public function getUserAttribute(Request $request, Response $response, array $params)
    {
        $userId = $params['userId'];
        $users = [
            ['id' => 1, 'firstName' => 'John', 'lastName' => 'Smith', 'email' => 'john@smith.com'],
            ['id' => 2, 'firstName' => 'Bob', 'lastName' => 'Dole', 'email' => 'bob@dole.com']
        ];
        $matchedUser = array_filter($users, function($user) use ($userId) {
            return $user['id'] == $userId;
        });
        if (!$matchedUser || !isset($matchedUser[0][$params['attribute']])) {
            return $response->withStatus(404)->getBody()->write('User not found.');
        }
        return $response->getBody()->write($matchedUser[0][$params['attribute']]);
    }
}
