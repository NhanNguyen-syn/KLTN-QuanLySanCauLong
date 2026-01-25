<?php

return [
    [
        'name' => 'Thống kê doanh thu',
        'flag' => 'revenue-statistics.index',
    ],
    [
        'name' => 'Xem chi tiết',
        'flag' => 'revenue-statistics.view',
        'parent_flag' => 'revenue-statistics.index',
    ],
    [
        'name' => 'Xuất báo cáo',
        'flag' => 'revenue-statistics.export',
        'parent_flag' => 'revenue-statistics.index',
    ],
];
