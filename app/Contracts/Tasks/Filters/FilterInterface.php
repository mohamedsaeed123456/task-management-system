<?php

namespace App\Contracts\Tasks\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * Apply the filter to the query
     */
    public function apply(Builder $query, Request $request): Builder;

    /**
     * Check if this filter should be applied
     */
    public function shouldApply(Request $request): bool;
}
