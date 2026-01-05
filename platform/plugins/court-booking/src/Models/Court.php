<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends BaseModel
{
    protected $fillable = [
        'name', 'image', 'court_type_id', 'status_id', 'location', 'note', 'order', 'status'
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function type(): BelongsTo { return $this->belongsTo(CourtType::class, 'court_type_id'); }
    public function courtStatus(): BelongsTo { return $this->belongsTo(CourtStatus::class, 'status_id'); }
    public function slots(): HasMany { return $this->hasMany(CourtSlot::class); }
}

