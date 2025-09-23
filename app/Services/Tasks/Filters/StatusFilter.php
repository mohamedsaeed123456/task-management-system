<?php

namespace App\Services\Tasks\Filters;

use App\Contracts\Tasks\Filters\FilterInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter implements FilterInterface
{
    /**
     * Apply status filter to the query
     */
    public function apply(Builder $query, Request $request): Builder
    {
        return $query->where('status', $request->status);
    }

    /**
     * Check if status filter should be applied
     */
    public function shouldApply(Request $request): bool
    {
        return $request->has('status') && $request->status !== '';
    }
}
