<?php

namespace Botble\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'campaign_id',
        'member_id',
        'status',
        'sent_at',
        'opened_at',
        'clicked_at',
        'error',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(EmailCampaign::class, 'campaign_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function markAsOpened(): void
    {
        if (!$this->opened_at) {
            $this->update([
                'status' => 'opened',
                'opened_at' => now(),
            ]);

            $this->campaign->increment('open_count');
        }
    }

    public function markAsClicked(): void
    {
        $this->markAsOpened();

        if (!$this->clicked_at) {
            $this->update([
                'status' => 'clicked',
                'clicked_at' => now(),
            ]);

            $this->campaign->increment('click_count');
        }
    }
}
