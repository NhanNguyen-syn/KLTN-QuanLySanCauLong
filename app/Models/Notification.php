<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id','type','channel','payload','status','sent_at'];
    protected $casts = ['payload' => 'array', 'sent_at' => 'datetime'];
}

