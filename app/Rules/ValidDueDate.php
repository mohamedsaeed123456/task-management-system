<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\DateHelper;

class ValidDueDate implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($value === null || $value === '') {
            return true;
        }
        try {
            DateHelper::validateDateFormat($value, 'date');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message(): string
    {
        return 'The :attribute must be a valid date format (Y-m-d) or (Y/m/d).';
    }
}
