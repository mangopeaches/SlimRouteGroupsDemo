<?php
use SlimRouteGroups\Routes;

use SlimRouteGroupsDemo\Middleware\AdditionalDataMiddleware;

Routes::init([
    new SlimRouteGroupsDemo\Routes\UserRoutes($app, [
        'withData' => new AdditionalDataMiddleware()
    ])
]);
