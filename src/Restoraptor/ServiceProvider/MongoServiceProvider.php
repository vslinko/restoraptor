<?php

namespace Restoraptor\ServiceProvider;

use Silex\ServiceProviderInterface,
    Silex\Application;

use Mongo;

class MongoServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['mongo.connection'] = $app->share(function () use ($app) {
            return new Mongo($app['mongo.server'], $app['mongo.options']);
        });

        $app['mongo.database'] = $app->share(function () use ($app) {
            return $app['mongo.connection']->selectDb($app['mongo.database_name']);
        });
    }

    public function boot(Application $app)
    {
    }
}
