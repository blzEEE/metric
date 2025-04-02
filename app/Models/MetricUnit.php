<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricUnit extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];

    public function metric(){
        return $this->hasOne(Metric::class);
    }
}
