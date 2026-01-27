<?php

namespace Botble\ProductsServices\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'price' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
