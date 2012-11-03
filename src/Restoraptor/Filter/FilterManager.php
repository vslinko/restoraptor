<?php

namespace Restoraptor\Filter;

use Silex\Application;

class FilterManager
{
    protected $app;
    protected $filters = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    public function filter($collectionName)
    {
        $query = [];

        /** @var $filter \Restoraptor\Filter\FilterInterface */
        foreach ($this->filters as $filter) {
            if ($filter->support($collectionName)) {
                $filter->filter($this->app, $query);
            }
        }

        return $query;
    }
}
