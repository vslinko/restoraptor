<?php

namespace Restoraptor\ServiceProvider;

use Silex\ServiceProviderInterface,
    Silex\Application;

use Restoraptor\Filter\SoftDeleteFilter,
    Restoraptor\Behaviour\RestBehaviour,
    Restoraptor\Filter\FilterManager;

class BehaviourServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['filter_manager'] = $app->share(function () use ($app) {
            return new FilterManager($app);
        });

        $app['behaviour'] = $app->share(function () use ($app) {
            return new RestBehaviour($app['mongo.database'], $app['filter_manager'], $app['soft_delete']);
        });

        $app['soft_delete'] = true;
    }

    public function boot(Application $app)
    {
        if ($app['soft_delete']) {
            $app['filter_manager']->addFilter(new SoftDeleteFilter());
        }
    }
}
