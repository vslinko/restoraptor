<?php

namespace Restoraptor\Filter;

use Silex\Application;

class SoftDeleteFilter implements FilterInterface
{
    public function filter(Application $app, &$query)
    {
        $query['deleted-at'] = ['$exists' => false];
    }

    public function support($collectionName)
    {
        return true;
    }
}
