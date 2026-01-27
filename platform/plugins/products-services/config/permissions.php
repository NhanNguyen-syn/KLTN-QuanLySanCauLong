<?php

return [
    [
        'name' => 'Product Categories',
        'flag' => 'product-categories.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'product-categories.create',
        'parent_flag' => 'product-categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'product-categories.edit',
        'parent_flag' => 'product-categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'product-categories.destroy',
        'parent_flag' => 'product-categories.index',
    ],
    [
        'name' => 'Products',
        'flag' => 'products.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'products.create',
        'parent_flag' => 'products.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'products.edit',
        'parent_flag' => 'products.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'products.destroy',
        'parent_flag' => 'products.index',
    ],
];
