<?php

namespace App\Services\Tasks\Filters;

use App\Contracts\Tasks\Filters\FilterInterface;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DueDateRangeFilter implements FilterInterface
{
    /**
     * Apply due date range filter to the query
     */
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->has('due_from') && $request->due_from !== '') {
            $validatedDate = DateHelper::validateDateFormat($request->due_from, 'due_from');
            $query->whereDate('due_date', '>=', $validatedDate);
        }
        
        if ($request->has('due_to') && $request->due_to !== '') {
            $validatedDate = DateHelper::validateDateFormat($request->due_to, 'due_to');
            $query->whereDate('due_date', '<=', $validatedDate);
        }

        return $query;
    }

    /**
     * Check if due date range filter should be applied
     */
    public function shouldApply(Request $request): bool
    {
        return ($request->has('due_from') && $request->due_from !== '') ||
               ($request->has('due_to') && $request->due_to !== '');
    }
}
