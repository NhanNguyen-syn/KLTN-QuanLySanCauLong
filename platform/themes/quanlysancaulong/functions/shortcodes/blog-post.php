<?php

use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;

use Botble\Blog\Models\Category as BlogCategory;
use Botble\Blog\Models\Post;

Shortcode::register('blog-post', __('Blog Post'), __('Blog posts grid by categories'), function (ShortcodeCompiler $shortcode) {
    // Normalize category ids input (array or comma-separated string)
    $categoryIds = [];
    $categoryIds = [];
    $rawCategories = $shortcode->blog_categories;

    if (! empty($rawCategories)) {
        if (is_string($rawCategories) && str_starts_with($rawCategories, '[') && str_ends_with($rawCategories, ']')) {
            // Handle JSON string from admin, e.g., "[\"9\",\"10\"]"
            $decoded = json_decode($rawCategories, true);
            if (is_array($decoded)) {
                $categoryIds = array_map('intval', $decoded);
            }
        } elseif (is_string($rawCategories)) {
            // Handle comma-separated string, e.g., "9,10"
            $categoryIds = array_map('intval', explode(',', $rawCategories));
        } elseif (is_array($rawCategories)) {
            // Handle array if already parsed
            $categoryIds = array_map('intval', $rawCategories);
        }
    }

    $categoryIds = array_filter($categoryIds);

    $title = $shortcode->title ?: __('Bài viết');
    $subtitle = $shortcode->subtitle ?: '';
    $limit = (int)($shortcode->limit ?: 6);

    $categories = BlogCategory::query()
        ->when($categoryIds, fn ($q) => $q->whereIn('id', $categoryIds))
        ->orderBy('name')
        ->get(['id', 'name']);

    // Get posts in any of selected categories; if none selected, get latest posts
    $paginator = Post::query()
        ->with(['slugable', 'categories', 'author'])
        ->when($categoryIds, function ($q) use ($categoryIds) {
            $q->whereHas('categories', function ($c) use ($categoryIds) {
                $c->whereIn('categories.id', $categoryIds);
            });
        })
        ->orderByDesc('created_at')
        ->paginate($limit);

    $posts = $paginator->getCollection();
    $paginationHtml = $paginator->appends(request()->query())->links()->toHtml();

    return Theme::partial('shortcodes.blog-post', compact('shortcode', 'title', 'subtitle', 'categories', 'posts', 'paginationHtml'));
});

Shortcode::setAdminConfig('blog-post', function (array $attributes) {
    return ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'title',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Title'))
                ->placeholder(__('Bài viết nổi bật'))
                ->defaultValue('')
                ->toArray()
        )
        ->add(
            'subtitle',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Subtitle'))
                ->placeholder(__('Mô tả ngắn (tùy chọn)'))
                ->defaultValue('')
                ->toArray()
        )
        ->add(
            'blog_categories[]',
            SelectField::class,
            SelectFieldOption::make()
                ->label(__('Blog Categories'))
                ->choices(BlogCategory::query()->pluck('name', 'id')->all())
                ->multiple()
                ->toArray()
        )
        ->add(
            'limit',
            TextField::class,
            TextFieldOption::make()
                ->label(__('Posts Limit'))
                ->placeholder('8')
                ->defaultValue('8')
                ->toArray()
        );
});

