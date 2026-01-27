<?php

namespace Botble\ProductsServices\Tables;

use Botble\ProductsServices\Models\ProductCategory;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProductCategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProductCategory::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('product-categories.create'))
            ->addActions([
                EditAction::make()->route('product-categories.edit'),
                DeleteAction::make()->route('product-categories.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('product-categories.edit')->label('Tên danh mục'),
                FormattedColumn::make('icon')->label('Icon'),
                FormattedColumn::make('order')->label('Thứ tự'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('product-categories.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select(['id', 'name', 'slug', 'icon', 'order', 'status', 'created_at'])
                    ->orderBy('order', 'asc');
            });
    }
}
