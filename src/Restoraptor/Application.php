<?php

namespace Restoraptor;

use Symfony\Component\HttpFoundation\Response,
    Silex\Application as SilexApplication;

use Restoraptor\ControllerProvider\RestoraptorControllerProvider,
    Restoraptor\ServiceProvider\BehaviourServiceProvider,
    Restoraptor\ServiceProvider\MongoServiceProvider,
    Silex\Provider\UrlGeneratorServiceProvider;

use MongoId;

class Application extends SilexApplication
{
    const VERSION = "0.0.1-dev";

    public function __construct($server, $databaseName, $options = ['connect' => true])
    {
        parent::__construct();

        $this['mongo.server'] = $server;
        $this['mongo.database_name'] = $databaseName;
        $this['mongo.options'] = $options;

        $this->register(new UrlGeneratorServiceProvider());
        $this->register(new MongoServiceProvider());
        $this->register(new BehaviourServiceProvider());
        $this->mount('/', new RestoraptorControllerProvider());

        $this->before(function () {
            $request = $this['request'];

            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });

        $this->error(function () {
            return new Response();
        });
    }

    public function json($data = [], $status = 200, $headers = [])
    {
        if (is_array($data)) {
            $normalizeMongoId = function (&$element) {
                if (is_array($element) && isset($element['_id']) && $element['_id'] instanceof MongoId) {
                    $element['id'] = (string) $element['_id'];
                    unset($element['_id']);
                }
            };

            $normalizeMongoId($data);
            array_walk($data, $normalizeMongoId);
        }

        return parent::json($data, $status, $headers);
    }
}
