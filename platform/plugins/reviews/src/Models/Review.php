<?php

namespace Botble\Reviews\Models;

use Botble\Base\Models\BaseModel;
use Botble\Member\Models\Member;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends BaseModel
{
    protected $table = 'reviews';

    protected $fillable = [
        'name',
        'member_id',
        'rating',
        'comment',
        'images',
        'helpful',
        'is_approved',
    ];

    protected $casts = [
        'images' => 'json',
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'helpful' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
