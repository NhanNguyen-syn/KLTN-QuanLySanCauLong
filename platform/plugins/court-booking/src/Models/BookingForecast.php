<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;

class BookingForecast extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'forecast_date',
        'hour',
        'court_id',
        'predicted_bookings',
        'confidence_score',
        'actual_bookings',
    ];

    protected $casts = [
        'forecast_date' => 'date',
        'confidence_score' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function isAccurate(): bool
    {
        if ($this->actual_bookings === null) {
            return false;
        }

        $diff = abs($this->actual_bookings - $this->predicted_bookings);
        return $diff <= 1; // Within 1 booking is considered accurate
    }

    public function getAccuracyPercentage(): ?float
    {
        if ($this->actual_bookings === null || $this->predicted_bookings == 0) {
            return null;
        }

        $diff = abs($this->actual_bookings - $this->predicted_bookings);
        return max(0, 100 - ($diff / max($this->predicted_bookings, 1) * 100));
    }
}
