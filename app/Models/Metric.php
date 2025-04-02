<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    /**
     * The attributes that should be guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded  = ['id'];

    /**
     * Связь для целевого направления
     */
    public function metricTargetOrder()
    {
        return $this->belongsTo(MetricTargetOrder::class);
    }

    /**
     * Связь для строк документа ввода показателей
     */
    public function inputDocumentValue()
    {
        return $this->hasMany(InputDocumentValue::class);
    }

    /**
     * Связь для категорий показателей
     */
    public function metricCategory()
    {
        return $this->belongsTo(MetricCategory::class);
    }

    /**
     * Связь для периодичности показателей
     */
    public function metricPeriod()
    {
        return $this->belongsTo(MetricPeriod::class);
    }

    /**
     * Связь для единиц измерения показателей
     */
    public function metricUnit()
    {
        return $this->belongsTo(MetricUnit::class);
    }

    /**
     * Связь для расчетных данных
     */
    public function metricCalcData()
    {
        return $this->hasMany(MetricCalcData::class);
    }

}
