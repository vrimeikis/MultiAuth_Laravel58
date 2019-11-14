<?php

declare(strict_types = 1);

namespace App\Helpers;

/**
 * Class Math
 *
 * @package App\Helpers
 */
class Math
{
    /**
     * @param float $firstValue
     * @param float $secondValue
     *
     * @return float
     */
    public static function calculatePercent(float $firstValue, float $secondValue): float {
        if ($firstValue == 0) {
            return (float)0;
        }

        return (float)(($secondValue * 100) / $firstValue);
    }
}