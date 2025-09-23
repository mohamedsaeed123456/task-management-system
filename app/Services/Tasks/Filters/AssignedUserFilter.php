<?php

namespace App\Services\Tasks\Filters;

use App\Contracts\Tasks\Filters\FilterInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AssignedUserFilter implements FilterInterface
{
    /**
     * Apply assigned user filter to the query
     */
    public function apply(Builder $query, Request $request): Builder
    {
        return $query->where('assigned_to', $request->assigned_to);
    }

    /**
     * Check if assigned user filter should be applied
     * Only managers can filter by assigned user
     */
    public function shouldApply(Request $request): bool
    {
        $user = $request->user();
        
        // Check if user is trying to filter by assigned_to
        if ($request->has('assigned_to') && $request->assigned_to !== '') {
            // Only managers can filter by assigned user
            if ($user->role !== 'manager') {
                throw new \Exception('Forbidden: Only managers can filter by assigned user', 403);
            }
            return true;
        }
        
        return false;
    }
}
