<?php

namespace Botble\ProductsServices\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductCategory extends BaseModel
{
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ProductCategory $category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function (ProductCategory $category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
