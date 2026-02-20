<?php

namespace Botble\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'segment_target',
        'trigger_type',
        'trigger_config',
        'status',
        'scheduled_at',
        'sent_count',
        'open_count',
        'click_count',
    ];

    protected $casts = [
        'trigger_config' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(CampaignLog::class, 'campaign_id');
    }

    public function getOpenRate(): float
    {
        if ($this->sent_count == 0) {
            return 0;
        }

        return round(($this->open_count / $this->sent_count) * 100, 2);
    }

    public function getClickRate(): float
    {
        if ($this->sent_count == 0) {
            return 0;
        }

        return round(($this->click_count / $this->sent_count) * 100, 2);
    }

    public function isReady(): bool
    {
        return $this->status === 'active' &&
            !empty($this->subject) &&
            !empty($this->body);
    }
}
