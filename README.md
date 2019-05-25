# SlimRouteGroupsDemo

This is a sample app to demonstrate the usage of the SlimRouteGroups package.

## Setup

First clone the repo and then install composer dependencies.
```bash
composer install
```

Then you can launch the application with the built in php server (make sure you're in the project directory of you can use the absolute path to index.php).
```bash
php -S localhost:8080 index.php
```

## Structure

I made a really simple slim app with the following structure:
```
Controllers/ - controller classes to handle requests to route endpoints
Middleware/ - various middleware functions
Routes/ - SlimRouteGroups route implementations
```

Within src there are also the files:
```
dependencies.php - attaches dependencies to Slim's app container
routes.php - this is where routes are applied to the Slim Router
```

Obviously index.php is where we configure and launch the app.

## Routes Explained

Here's how we've utilized SlimGroupRoutes in Routes/UserRoutes.php
```php
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
            $self->get('/{attribute}', 'SlimRouteGroupsDemo\Controllers\UserController:getUserAttribute')->add(new WrapperMiddleware());
        });
    });
}
```

Here's what the outcome of this would look like if you're using default Slim routes off the app container directly:
```php
use SlimRouteGroupDemo\Middleware\AdditionalDataMiddleware;
use SlimRouteGroupDemo\Middleware\WrapperMiddleware;

$app->group('/users', function($app) {
    $app->get('', 'SlimRouteGroupsDemo\Controllers\UserController:getAllUsers');
    $app->get('/withData', 'SlimRouteGroupsDemo\Controllers\UserController:getAllUsersWithData')->add(new AdditionalDataMiddleware());
    $app->group('/{userId: [0-9]+}', function($app) {
        $app->get('', 'SlimRouteGroupsDemo\Controllers\UserController:getUser');
        $app->get('/{attribute}', 'SlimRouteGroupsDemo\Controllers\UserController:getUserAttribute')->add(new WrapperMiddleware());
    });
});
```

Notice it's not very different, but that's the intention. You shouldn't have to learn anything new to use this, it should just provide structure to your existing knowledge of the Router.

So where are the differences here? Take a look at the `/users/withData` routes between the two. Where does this withData method come from? It comes from our instantiation of the UserRoutes instance in our routes.php file.
```php
<?php
use SlimRouteGroups\Routes;

use SlimRouteGroupsDemo\Middleware\AdditionalDataMiddleware;

Routes::init([
    new SlimRouteGroupsDemo\Routes\UserRoutes($app, [
        'withData' => new AdditionalDataMiddleware()
    ])
]);
```

As you can see, you can define your middleware at the time you instantiate your Routes object and it will be available as a member function. It's not incredibly different, but an alternative to attaching everything with add on Slims Route object.

However, you are still fully capable of using the add syntax to add middleware directly, as you can see with the `/users/{userId: [0-9]+}/{attribute}` route; use whichever you prefer.

