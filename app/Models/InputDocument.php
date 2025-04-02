<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputDocument extends Model
{
    use HasFactory;

    protected $table = 'input_documents';

    protected $fillable = [
        'metric_category_id',
        'metric_period_id',
        'year',
        'quarter',
        'month'
    ];

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
     * Связь для периодичности показателей
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь для строк документа
     */
    public function inputDocumentValues()
    {
        return $this->hasMany(InputDocumentValue::class);
    }
}
