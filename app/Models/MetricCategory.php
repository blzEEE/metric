<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class MetricCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that should be guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded  = ['id'];

    protected $fillable = [
        'name'
    ];

    /**
     * Связь для документов ввода показателей
     */
    public function inputDocuments()
    {
        return $this->hasMany(InputDocument::class);
    }

    /**
     * Связь для пользователей с ограничениями
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Связь для показателей
     */
    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }

    /**
     * Связь для периодичности показателей
     */
    public function metricPeriods()
    {
        return $this->belongsToMany(MetricPeriod::class, 'metrics', 'metric_period_id', 'metric_category_id');
    }

    public function scopeAvailable($query)
    {
        if (Auth::user()->user_role_id === UserRole::ROLE_OPERATOR) {
            return $query->whereHas('users', function($query) {
                $query->where('users.id', Auth::user()->id);
            });
        } else {
            return $query;
        }
    }

    public function scopeHasMetrics($query, $year)
    {
        return $query->whereHas('metrics', function($query) use ($year) {
            $query->whereYear('metrics.date_begin', '<=', $year)
                ->where(function($query) use ($year) {
                    $query->whereYear('metrics.date_end', '>=', $year);
                    $query->orWhereNull('metrics.date_end');
                });
        });
    }

}
