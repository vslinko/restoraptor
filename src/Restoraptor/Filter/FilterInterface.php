<?php

namespace Restoraptor\Filter;

use Silex\Application;

interface FilterInterface
{
    public function filter(Application $app, &$query);

    public function support($collectionName);
}
