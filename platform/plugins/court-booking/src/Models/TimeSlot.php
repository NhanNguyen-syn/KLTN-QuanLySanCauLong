<?php

namespace Botble\CourtBooking\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = ['label','start_time','end_time','days_of_week','duration_minutes'];
}

