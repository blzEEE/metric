<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOwnership extends Model
{
    use HasFactory;

    public const OWNERSHIP_STATE = 1; // Государственная
    public const OWNERSHIP_PRIVATE = 2; // Частная
}
