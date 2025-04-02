<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputDocumentValueCalcData extends Model
{
    use HasFactory;

    protected $table = 'input_document_value_calc_data';

    protected $fillable = [
        'metric_calc_data_id',
        'value'
    ];

    /**
     * Связь на справочник данных для расчета
     */
    public function metricCalcData()
    {
        return $this->belongsTo(MetricCalcData::class);
    }
}
