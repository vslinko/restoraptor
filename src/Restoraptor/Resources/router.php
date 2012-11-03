<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Restoraptor\Application(getenv('MONGODB_SERVER'), getenv('MONGODB_DATABASE_NAME'));
$app->run();
