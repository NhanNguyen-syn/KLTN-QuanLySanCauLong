<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends BaseModel
{
    protected $fillable = [
        'name', 'slug', 'image', 'court_type_id', 'status_id', 'location', 'note', 'order', 'status',
        'default_price', 'member_price', 'address', 'booking_url', 'time_display',
        'description', 'surface', 'court_size', 'lighting', 'air_conditioned',
        'features', 'gallery', 'availability',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'air_conditioned' => 'boolean',
        'features' => 'array',
        'gallery' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($court) {
            if (empty($court->slug)) {
                $court->slug = \Illuminate\Support\Str::slug($court->name);
            }
            // Ensure unique slug
            $originalSlug = $court->slug;
            $count = 1;
            while (static::where('slug', $court->slug)->exists()) {
                $court->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($court) {
            if ($court->isDirty('name') && !$court->isDirty('slug')) {
                $court->slug = \Illuminate\Support\Str::slug($court->name);
                $originalSlug = $court->slug;
                $count = 1;
                while (static::where('slug', $court->slug)->where('id', '!=', $court->id)->exists()) {
                    $court->slug = $originalSlug . '-' . $count++;
                }
            }
        });
    }

    public function type(): BelongsTo { return $this->belongsTo(CourtType::class, 'court_type_id'); }
    public function courtStatus(): BelongsTo { return $this->belongsTo(CourtStatus::class, 'status_id'); }
    public function slots(): HasMany { return $this->hasMany(CourtSlot::class); }
}

