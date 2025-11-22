<?php

return [
    // Court bookings (placeholder CRUD)
    [
        'name' => 'Court bookings',
        'flag' => 'court-booking.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'court-booking.create',
        'parent_flag' => 'court-booking.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'court-booking.edit',
        'parent_flag' => 'court-booking.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'court-booking.destroy',
        'parent_flag' => 'court-booking.index',
    ],

    // Court slots management
    [
        'name' => 'Court slots',
        'flag' => 'court-slot.index',
    ],
    [
        'name' => 'Bulk status',
        'flag' => 'court-slot.bulk-status',
        'parent_flag' => 'court-slot.index',
    ],
];
