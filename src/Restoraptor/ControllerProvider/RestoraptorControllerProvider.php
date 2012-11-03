<?php

namespace Restoraptor\ControllerProvider;

use Silex\ControllerProviderInterface,
    Silex\Application;

class RestoraptorControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $controllers->get('/{collection}/', function ($collection) use ($app) {
            $cursor = $app['behaviour']->listCollection($collection);

            return $app->json(array_values(iterator_to_array($cursor)));
        });


        $controllers->delete('/{collection}/', function ($collection) use ($app) {
            $app['behaviour']->dropCollection($collection);

            return $app->json(null, 204);
        });


        $controllers->post('/{collection}/', function ($collection) use ($app) {
            $document = $app['behaviour']->createDocument($collection, $app['request']->request->all());

            $location = $app['url_generator']->generate('morest_get', [
                'collection' => $collection,
                'id' => (string) $document['_id'],
            ], true);

            return $app->json($document, 201, ['Location' => $location]);
        });


        $controllers->get('/{collection}/{id}', function ($collection, $id) use ($app) {
            return $app->json($app['behaviour']->readDocument($collection, $id));
        })->bind('morest_get');


        $controllers->put('/{collection}/{id}', function ($collection, $id) use ($app) {
            $app['behaviour']->updateDocument($collection, $id, $app['request']->request->all());

            return $app->json(null, 204);
        });


        $controllers->delete('/{collection}/{id}', function ($collection, $id) use ($app) {
            $app['behaviour']->deleteDocument($collection, $id);

            return $app->json(null, 204);
        });


        return $controllers;
    }
}
