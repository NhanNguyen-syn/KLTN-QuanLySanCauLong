<?php

return [
    [
        'name' => 'Reviews',
        'flag' => 'reviews.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'reviews.destroy',
        'parent_flag' => 'reviews.index',
    ],
    [
        'name' => 'Analyze (AI)',
        'flag' => 'reviews.analyze',
        'parent_flag' => 'reviews.index',
    ],
];
