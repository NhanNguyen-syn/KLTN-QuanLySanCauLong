<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['user_id','action','entity_type','entity_id','meta'];
    protected $casts = ['meta' => 'array'];
}

