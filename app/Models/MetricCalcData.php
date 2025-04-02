<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricCalcData extends Model
{
    use HasFactory;

    protected $table = 'metric_calc_data';

    public $timestamps = false;

    protected $guarded  = ['id'];

    public $fillable = [
        'metric_id',
        'name',
        'description',
        'var_name',
    ];

    /**
     * Связь на показатель
     */
    public function metric(){
        return $this->belongsTo(Metric::class);
    }

    /**
     * Связь на фактически введенные данные для расчета
     */
    public function inputDocumentValueCalcData()
    {
        return $this->hasMany(InputDocumentValueCalcData::class);
    }
}
