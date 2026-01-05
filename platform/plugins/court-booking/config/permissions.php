<?php

return [
    // Courts CRUD
    [
        'name' => 'Courts',
        'flag' => 'courts.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'courts.create',
        'parent_flag' => 'courts.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'courts.edit',
        'parent_flag' => 'courts.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'courts.destroy',
        'parent_flag' => 'courts.index',
    ],

    // Booking List
    [
        'name' => 'Danh sách đặt sân',
        'flag' => 'booking-list.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'booking-list.edit',
        'parent_flag' => 'booking-list.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'booking-list.destroy',
        'parent_flag' => 'booking-list.index',
    ],
];
