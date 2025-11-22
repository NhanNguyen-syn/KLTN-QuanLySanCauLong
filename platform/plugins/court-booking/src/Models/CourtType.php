<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtType extends Model
{
    protected $fillable = ['name'];

    public function courts(): HasMany { return $this->hasMany(Court::class); }
}

