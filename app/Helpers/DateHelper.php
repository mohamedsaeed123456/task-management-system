<?php

namespace App\Helpers;

class DateHelper
{
    /**
     * Validate and normalize date format
     */
    public static function validateDateFormat(string $date, string $field = 'date'): string
    {
        // Remove any whitespace
        $date = trim($date);
        // Define valid date formats
        $validFormats = [
            'Y-m-d',     // 2025-10-20
            'Y/m/d',     // 2025/10/20
        ];
        
        foreach ($validFormats as $format) {
            $parsedDate = \DateTime::createFromFormat($format, $date);
            if ($parsedDate && $parsedDate->format($format) === $date) {
                // Return in Y-m-d format (MySQL standard)
                return $parsedDate->format('Y-m-d');
            }
        }
        
        // If no valid format found, throw exception
        throw new \Exception("Invalid date format for {$field}. Expected formats: Y-M-D, Y/M/D", 422);
    }
}
