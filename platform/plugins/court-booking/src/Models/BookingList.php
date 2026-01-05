<?php

namespace Botble\CourtBooking\Models;

use Botble\Base\Models\BaseModel;

class BookingList extends BaseModel
{
    protected $table = 'court_bookings_list';

    /**
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'order_code',
        'court_id',
        'court_name',
        'date',
        'start_time',
        'end_time',
        'status',
        'customer_name',
        'contact',
        'price',
        'paid_amount',
        'notes',
        'invoice_created_at',
        'invoice_updated_at',
    ];
}

