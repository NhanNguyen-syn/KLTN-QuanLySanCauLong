<?php

namespace Botble\CourtBooking\Tables;

use Botble\CourtBooking\Models\Court;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CourtTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Court::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('courts.create'))
            ->addActions([
                EditAction::make()->route('courts.edit'),
                DeleteAction::make()->route('courts.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make()->label('Ảnh'),
                NameColumn::make()->route('courts.edit')->label('Tên sân'),
                // Loại sân
                FormattedColumn::make('court_type_id')->label('Loại sân')->getValueUsing(function (FormattedColumn $column) {
                    $item = $column->getItem();
                    return optional($item->type)->name ?: '-';
                }),
                // Tình trạng sân
                FormattedColumn::make('status_id')->label('Tình trạng')->getValueUsing(function (FormattedColumn $column) {
                    $item = $column->getItem();
                    return optional($item->courtStatus)->name ?: '-';
                }),
                // Thứ tự
                FormattedColumn::make('order')->label('Thứ tự')->getValueUsing(function ($column, $value) {
                    return (string) ($value ?? 0);
                }),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('courts.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->with(['type', 'courtStatus'])
                    ->select(['id','name','image','court_type_id','status_id','order','status','created_at']);
            });
    }
}

