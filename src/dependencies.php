<?php

$container = $app->getContainer();

$container['SlimRouteGroupsDemo\Controllers\UserController'] = function($app) {
    return new SlimRouteGroupsDemo\Controllers\UserController($app);
};
