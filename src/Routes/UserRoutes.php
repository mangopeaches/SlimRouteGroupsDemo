<?php
namespace SlimRouteGroupsDemo\Routes;

use SlimRouteGroups\Routes;
use SlimRouteGroupsDemo\Middleware\WrapperMiddleware;

/**
 * Define user routes.
 * @author Thomas Breese <thomasjbreese@gmail.com>
 */
class UserRoutes extends Routes
{
    /**
     * Define user routes.
     */
    public function __invoke()
    {
        $self = $this;

        $this->group('/users', function($app) use ($self) {
            $self->get('', 'SlimRouteGroupsDemo\Controllers\UserController:getAllUsers');
            $self->withData($self->get('/withData', 'SlimRouteGroupsDemo\Controllers\UserController:getAllUsersWithData'));
            
            $self->group('/{userId: [0-9]+}', function($app) use ($self) {
                $self->get('', 'SlimRouteGroupsDemo\Controllers\UserController:getUser');
                $self->get('/{attribute}', 'SlimRouteGroupsDemo\Controllers\UserController:getUserAttribute')
                    ->add(new WrapperMiddleware());
            });
        });
    }
}
