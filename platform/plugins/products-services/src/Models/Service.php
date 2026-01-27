<?php

namespace Botble\ProductsServices\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Service extends BaseModel
{
    protected $table = 'extra_services';

    protected $fillable = [
        'name',
        'description',
        'content',
        'price',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => 'string',
    ];
}
