<?php

namespace Botble\ProductsServices\Tables;

use Botble\ProductsServices\Models\Service;
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

class ServiceTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Service::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('services.create'))
            ->addActions([
                EditAction::make()->route('services.edit'),
                DeleteAction::make()->route('services.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make()->label('Ảnh'),
                NameColumn::make()->route('services.edit')->label('Tên dịch vụ'),
                FormattedColumn::make('price')->label('Giá')->getValueUsing(function (FormattedColumn $column) {
                    return $column->getItem()->price ?: 'Liên hệ';
                }),
                FormattedColumn::make('order')->label('Thứ tự'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('services.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select(['id', 'name', 'price', 'image', 'order', 'status', 'created_at'])
                    ->orderBy('order', 'asc');
            });
    }
}
