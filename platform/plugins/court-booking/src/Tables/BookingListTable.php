<?php

namespace Botble\CourtBooking\Tables;

use Botble\CourtBooking\Models\BookingList;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\FormattedColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;

class BookingListTable extends TableAbstract
{
    protected string $orderBy = 'created_at';

    protected string $orderDirection = 'desc';

    public function setup(): void
    {
        $this
            ->model(BookingList::class)
            ->addActions([
                // Chuyển sang chỉnh sửa theo nhóm đơn hàng (sử dụng id nhỏ nhất trong nhóm)
                EditAction::make()->route('booking-list.edit'),
                DeleteAction::make()->route('booking-list.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table->eloquent($this->query());

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        // Gom theo order_code để 1 đơn hàng hiển thị thành 1 dòng
        $query = $this->getModel()
            ->query()
            ->selectRaw(
                'MIN(id) as id, order_code, MIN(customer_name) as customer_name, MIN(contact) as contact, ' .
                'COUNT(*) as items_count, SUM(price) as price, SUM(paid_amount) as paid_amount, ' .
                'MIN(status) as status, MIN(created_at) as created_at'
            )
            ->groupBy('order_code');

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            Column::make('order_code')->title('Mã đơn hàng')->alignLeft(),
            Column::make('customer_name')->title('Khách hàng')->alignLeft(),
            Column::make('contact')->title('Liên hệ')->alignLeft(),
            Column::make('items_count')->title('Số mục')->alignCenter(),
            Column::make('price')->title('Tổng giá')->alignCenter(),
            Column::make('paid_amount')->title('Tổng đã cọc')->alignCenter(),
            FormattedColumn::make('status')->title('Trạng thái')->alignCenter()->renderUsing(function (FormattedColumn $column, $value) {
                $labels = [
                    'pending' => 'Chờ xử lý',
                    'processing' => 'Đang xử lý',
                    'paid' => 'Đã cọc',
                    'completed' => 'Hoàn tất',
                    'cancelled' => 'Đã hủy',
                ];
                $colors = [
                    'pending' => 'warning',
                    'processing' => 'warning',
                    'paid' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                ];
                $status = (string) $value;
                $label = $labels[$status] ?? $status;
                $color = $colors[$status] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . e($label) . '</span>';
            }),
            CreatedAtColumn::make(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('booking-list.destroy'),
        ];
    }


}

