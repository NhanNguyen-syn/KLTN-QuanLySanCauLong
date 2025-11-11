<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends Model
{
    protected $fillable = [
        'name', 'court_type_id', 'status_id', 'location', 'note'
    ];

    public function type(): BelongsTo { return $this->belongsTo(CourtType::class, 'court_type_id'); }
    public function status(): BelongsTo { return $this->belongsTo(CourtStatus::class, 'status_id'); }
    public function slots(): HasMany { return $this->hasMany(CourtSlot::class); }
}

