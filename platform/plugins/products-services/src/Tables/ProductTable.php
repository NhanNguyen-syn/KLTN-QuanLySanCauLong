<?php

namespace Botble\ProductsServices\Tables;

use Botble\ProductsServices\Models\Product;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProductTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Product::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('products.create'))
            ->addActions([
                EditAction::make()->route('products.edit'),
                DeleteAction::make()->route('products.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make()->label('Ảnh'),
                NameColumn::make()->route('products.edit')->label('Tên sản phẩm'),
                FormattedColumn::make('category_id')->label('Danh mục')->getValueUsing(function (FormattedColumn $column) {
                    $item = $column->getItem();
                    return optional($item->category)->name ?: '-';
                }),
                FormattedColumn::make('price')->label('Giá')->getValueUsing(function (FormattedColumn $column) {
                    $item = $column->getItem();
                    return number_format($item->price, 0, ',', '.') . 'đ';
                }),
                FormattedColumn::make('order')->label('Thứ tự'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('products.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->with('category')
                    ->select(['id', 'name', 'category_id', 'price', 'image', 'order', 'status', 'created_at'])
                    ->orderBy('order', 'asc');
            });
    }
}
