<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourtSlot extends Model
{
    protected $fillable = ['court_id','start_at','end_at','status','base_price','applied_rule_id'];

    public function court(): BelongsTo { return $this->belongsTo(Court::class); }
}

