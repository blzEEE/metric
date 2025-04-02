<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public const ROLE_SYSADMIN = 1;
    public const ROLE_WATCHER = 2;
    public const ROLE_COMPANY_ADMIN = 3;
    public const ROLE_OPERATOR = 4;
}
