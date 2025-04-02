<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyType;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_emergency' => 'integer',
    ];

    /**
     * The attributes that should be guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded  = ['id'];

    protected $fillable = [
        'region_id',
        'company_type_id',
        'company_ownership_id',
        'company_level_id',
        'company_bed_capacity_id',
        'city',
        'name',
        'short_name',
        'address',
        'director_position',
        'director_name',
        'is_emergency',
        'date_begin_year',
        'date_begin_quarter',
        'date_begin_month',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function companyType() {
        return $this->belongsTo(CompanyType::class);
    }

    public function companyOwnership() {
        return $this->belongsTo(CompanyOwnership::class);
    }

    public function companyLevel() {
        return $this->belongsTo(CompanyLevel::class);
    }

    public function companyBedCapacity() {
        return $this->belongsTo(CompanyBedCapacity::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

}

