<?php

namespace Botble\ReceptionistPortal\Tables;

use Botble\ReceptionistPortal\Models\VipCustomer;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class VipCustomerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(VipCustomer::class)
            ->addActions([
                EditAction::make()->route('receptionist.vip.edit'),
                DeleteAction::make()->route('receptionist.vip.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('receptionist.vip'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('receptionist.vip.edit'),
            Column::make('phone')
                ->title('SĐT')
                ->width(120)
                ->searchable(),
            Column::make('type')
                ->title('Loại')
                ->width(100)
                ->renderUsing(fn(Column $column) => $column->getItem()->type_label),
            Column::make('discount_percent')
                ->title('Giảm giá')
                ->width(80)
                ->renderUsing(fn(Column $column) => $column->getItem()->formatted_discount),
            Column::make('current_debt')
                ->title('Công nợ')
                ->width(120)
                ->renderUsing(fn(Column $column) => number_format($column->getItem()->current_debt) . 'đ'),
            Column::make('credit_limit')
                ->title('Hạn mức')
                ->width(120)
                ->renderUsing(fn(Column $column) => number_format($column->getItem()->credit_limit) . 'đ'),
            Column::make('is_active')
                ->title('Trạng thái')
                ->width(100)
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
                'phone',
                'type',
                'discount_percent',
                'current_debt',
                'credit_limit',
                'is_active',
                'created_at',
            ]);
    }
}
