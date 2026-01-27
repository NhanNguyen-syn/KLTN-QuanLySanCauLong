<?php

use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\ProductsServices\Models\ProductCategory;
use Botble\ProductsServices\Models\Product;
use Botble\Media\Facades\RvMedia;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

// ============================================================================
// REGISTER SHORTCODE
// ============================================================================

Shortcode::register('products-grid', __('Products Grid'), __('Hiển thị lưới sản phẩm với bộ lọc danh mục'), function (ShortcodeCompiler $shortcode) {
    // Get selected category IDs
    $selectedCategoryIds = array_filter(explode(',', $shortcode->category_ids ?? ''));
    
    // Get selected product IDs
    $selectedProductIds = array_filter(explode(',', $shortcode->product_ids ?? ''));
    
    // Load categories
    $categoriesQuery = ProductCategory::query()
        ->where('status', 'published')
        ->orderBy('order');
    
    if (!empty($selectedCategoryIds)) {
        $categoriesQuery->whereIn('id', $selectedCategoryIds);
    }
    
    $categories = $categoriesQuery->get(['id', 'name', 'slug', 'icon']);
    
    // Load products
    $productsQuery = Product::query()
        ->with('category:id,name,slug')
        ->where('status', 'published')
        ->orderBy('order');
    
    if (!empty($selectedProductIds)) {
        $productsQuery->whereIn('id', $selectedProductIds);
    } elseif (!empty($selectedCategoryIds)) {
        // If no specific products selected, show all from selected categories
        $productsQuery->whereIn('category_id', $selectedCategoryIds);
    }
    
    $products = $productsQuery->get()->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image ? RvMedia::getImageUrl($product->image) : null,
            'category' => $product->category,
        ];
    });
    
    return Theme::partial('shortcodes.products-grid', compact('shortcode', 'categories', 'products'));
});

// ============================================================================
// ADMIN CONFIG
// ============================================================================

Shortcode::setAdminConfig('products-grid', function (array $attributes) {
    // Get all categories for selection
    $categoryOptions = ProductCategory::query()
        ->where('status', 'published')
        ->orderBy('order')
        ->pluck('name', 'id')
        ->toArray();
    
    // Get all products for selection  
    $productOptions = Product::query()
        ->where('status', 'published')
        ->orderBy('order')
        ->get()
        ->mapWithKeys(function ($product) {
            $categoryName = $product->category ? $product->category->name : 'Không danh mục';
            return [$product->id => $product->name . ' (' . $categoryName . ')'];
        })
        ->toArray();

    // Pre-process attributes for multi-select fields
    if (isset($attributes['category_ids']) && is_string($attributes['category_ids'])) {
        $attributes['category_ids'] = array_filter(explode(',', $attributes['category_ids']));
    }
    
    if (isset($attributes['product_ids']) && is_string($attributes['product_ids'])) {
        $attributes['product_ids'] = array_filter(explode(',', $attributes['product_ids']));
    }

    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Section Title'))
                ->placeholder(__('Sản Phẩm'))
                ->defaultValue('Sản Phẩm')
                ->toArray()
        )
        ->add(
            'category_ids',
            SelectField::class,
            SelectFieldOption::make()
                ->label(__('Chọn danh mục hiển thị'))
                ->choices($categoryOptions)
                ->searchable()
                ->multiple()
                ->helperText(__('Để trống để hiển thị tất cả danh mục'))
                ->toArray()
        )
        ->add(
            'product_ids',
            SelectField::class,
            SelectFieldOption::make()
                ->label(__('Chọn sản phẩm hiển thị'))
                ->choices($productOptions)
                ->searchable()
                ->multiple()
                ->helperText(__('Để trống để hiển thị tất cả sản phẩm từ danh mục đã chọn'))
                ->toArray()
        );
});

