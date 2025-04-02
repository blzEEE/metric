<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricCategoryUser extends Model
{
    use HasFactory;

    protected $table = 'metric_category_user';
    public $timestamps = false;
}
