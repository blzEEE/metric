<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricPeriod extends Model
{
    use HasFactory;

    public const PERIOD_YEAR = 1;
    public const PERIOD_QUARTER = 2;
    public const PERIOD_MONTH = 3;

    /**
     * Связь для показателей
     */
    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }
}
