<?php

namespace Botble\CourtBooking\Tables;

use Botble\Base\Facades\Html;
use Botble\CourtBooking\Models\Service;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ServiceTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Service::class)
            ->addActions([
                EditAction::make()->route('services.edit'),
                DeleteAction::make()->route('services.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('services.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('services.edit'),
            Column::make('category')
                ->title('Danh mục')
                ->width(120)
                ->orderable()
                ->searchable()
                ->renderUsing(fn(Column $column) => $column->getItem()->category_label),
            Column::make('type')
                ->title('Loại')
                ->width(100)
                ->orderable()
                ->renderUsing(fn(Column $column) => $column->getItem()->type_label),
            Column::make('price')
                ->title('Giá')
                ->width(120)
                ->orderable()
                ->renderUsing(fn(Column $column) => $column->getItem()->formatted_price),
            Column::make('stock')
                ->title('Tồn kho')
                ->width(100)
                ->orderable()
                ->renderUsing(function (Column $column) {
                    $item = $column->getItem();
                    if (!$item->track_stock) {
                        return '<span class="text-muted">∞</span>';
                    }
                    $class = $item->stock <= 5 ? 'text-danger' : ($item->stock <= 20 ? 'text-warning' : 'text-success');
                    return '<span class="' . $class . '">' . $item->stock . '</span>';
                }),
            Column::make('is_active')
                ->title('Trạng thái')
                ->width(100)
                ->orderable()
                ->renderUsing(
                    fn(Column $column) =>
                    $column->getItem()->is_active
                    ? '<span class="badge bg-success">Hoạt động</span>'
                    : '<span class="badge bg-secondary">Tắt</span>'
                ),
            CreatedAtColumn::make(),
        ];
    }

    public function query(): Builder|QueryBuilder
    {
        return $this->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'category',
                'type',
                'price',
                'stock',
                'track_stock',
                'is_active',
                'created_at',
            ]);
    }

    public function getFilters(): array
    {
        return [
            'category' => [
                'title' => 'Danh mục',
                'type' => 'select',
                'choices' => Service::getCategoryOptions(),
            ],
            'type' => [
                'title' => 'Loại',
                'type' => 'select',
                'choices' => Service::getTypeOptions(),
            ],
            'is_active' => [
                'title' => 'Trạng thái',
                'type' => 'select',
                'choices' => [
                    1 => 'Hoạt động',
                    0 => 'Tắt',
                ],
            ],
        ];
    }
}
