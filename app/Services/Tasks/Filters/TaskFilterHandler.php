<?php

namespace App\Services\Tasks\Filters;

use App\Contracts\Tasks\Filters\FilterInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TaskFilterHandler
{
    protected $filters = [];

    /**
     * Constructor - Register default filters
     */
    public function __construct()
    {
        $this->registerDefaultFilters();
    }

    /**
     * Register default filters
     */
    protected function registerDefaultFilters(): void
    {
        $this->addFilter(new StatusFilter());
        $this->addFilter(new AssignedUserFilter());
        $this->addFilter(new DueDateRangeFilter());
    }

    /**
     * Add a filter to the handler
     */
    public function addFilter(FilterInterface $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Apply all applicable filters to the query
     */
    public function applyFilters(Builder $query, Request $request): Builder
    {
        foreach ($this->filters as $filter) {
            if ($filter->shouldApply($request)) {
                $query = $filter->apply($query, $request);
            }
        }

        return $query;
    }
}
