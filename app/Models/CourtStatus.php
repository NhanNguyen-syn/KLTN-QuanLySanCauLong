<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtStatus extends Model
{
    protected $fillable = ['name'];

    public function courts(): HasMany { return $this->hasMany(Court::class, 'status_id'); }
}

