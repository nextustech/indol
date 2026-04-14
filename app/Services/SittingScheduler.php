<?php

namespace App\Services;

use Carbon\Carbon;

class SittingScheduler
{
    /**
     * Generate sitting dates with per-day ordering.
     *
     * Returns an array of arrays with keys:
     *  - date: Carbon instance of sitting
     *  - order: int visit order for that date (1-based)
     *
     * @param Carbon $startDate  Starting date (first day)
     * @param int $days          Number of days to iterate
     * @param int $perDay        Number of sittings per day
     * @param array $options     Options array. Supported keys:
     *                           - weekendRules: associative array dayOfWeek => allowedCount (e.g. [Carbon::SATURDAY=>1, Carbon::SUNDAY=>0])
     * @return array[]           Flat list of ['date' => Carbon, 'order' => int]
     */
    public static function generateSittings(Carbon $startDate, int $days, int $perDay, array $options = []) : array
    {
        $weekendRules = $options['weekendRules'] ?? [];
        $totalSessions = $options['totalSessions'] ?? null;

        $dates = [];

        // Work on a clone so caller's Carbon isn't mutated
        $current = $startDate->copy();
        
        $sessionCount = 0;
        $i = 0;
        
        while (true) {
            if ($totalSessions !== null) {
                if ($sessionCount >= $totalSessions) break;
            } else {
                if ($i >= $days) break;
            }

            $dayOfWeek = $current->dayOfWeek; // 0 (Sun) - 6 (Sat)

            // Determine allowed sittings for this date
            if (array_key_exists($dayOfWeek, $weekendRules)) {
                $allowed = (int) $weekendRules[$dayOfWeek];
            } else {
                $allowed = $perDay;
            }

            // If allowed is zero, skip creating sittings for this day
            if ($allowed > 0) {
                for ($s = 0; $s < $allowed; $s++) {
                    if ($totalSessions !== null && $sessionCount >= $totalSessions) break;
                    $dates[] = ['date' => $current->copy(), 'order' => $s + 1];
                    $sessionCount++;
                }
            }

            $current->addDay();
            $i++;
        }

        return $dates;
    }
}
