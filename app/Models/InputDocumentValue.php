<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputDocumentValue extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'metric_id',
        'value',
        'is_active'
    ];

    /**
     * Связь для показателей
     */
    public function metric()
    {
        return $this->belongsTo(Metric::class);
    }

    /**
     * Связь с данными для расчета
     */
    public function inputDocumentValueCalcData()
    {
        return $this->hasMany(InputDocumentValueCalcData::class);
    }
}
