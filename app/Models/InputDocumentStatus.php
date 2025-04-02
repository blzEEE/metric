<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputDocumentStatus extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 1;
    public const STATUS_APPROVE = 2;
}
