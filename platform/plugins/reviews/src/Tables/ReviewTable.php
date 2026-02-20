<?php

namespace Botble\Reviews\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\DataTables;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Botble\Reviews\Models\Review;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\Columns\DateColumn;
use Botble\Table\BulkActions\DeleteBulkAction;

class ReviewTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Review::class)
            ->addActions([
                \Botble\Table\Actions\EditAction::make()->route('reviews.edit'),
                \Botble\Table\Actions\DeleteAction::make()->route('reviews.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('reviews.destroy'),
            ]);
    }

    public function getFilters(): array
    {
         return [
            'rating' => [
                'title' => 'Đánh giá',
                'type' => 'select',
                'choices' => [
                    1 => '1 Sao',
                    2 => '2 Sao',
                    3 => '3 Sao',
                    4 => '4 Sao',
                    5 => '5 Sao',
                ],
                'validate' => 'required|in:1,2,3,4,5',
            ],
            'created_at' => [
                'title' => 'Ngày tạo',
                'type' => 'date',
            ],
            'is_approved' => [
                'title' => 'Trạng thái',
                'type' => 'select',
                'choices' => [
                    1 => 'Đã duyệt',
                    0 => 'Chờ duyệt',
                ],
            ],
            'filter_sort_by' => [
                'title' => 'Sắp xếp',
                'type' => 'select',
                'choices' => [
                    'newest' => 'Mới nhất',
                    'oldest' => 'Cũ nhất',
                    'rating_desc' => 'Đánh giá cao nhất',
                    'rating_asc' => 'Đánh giá thấp nhất',
                ],
            ],
        ];
    }

    // Override applyFilterCondition to handle custom 'sort' filter
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        if ($key == 'filter_sort_by') {
             // Sorting is handled in query(), skip WHERE condition for this virtual column
             return $query;
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * Extract the sort value from the filter request.
     * Filter data arrives as indexed arrays: filter_columns[0], filter_values[0], etc.
     */
    protected function getSortValueFromRequest(): ?string
    {
        $filterColumns = request()->input('filter_columns', []);
        $filterValues = request()->input('filter_values', []);

        if (!is_array($filterColumns) || !is_array($filterValues)) {
            return null;
        }

        foreach ($filterColumns as $index => $column) {
            if ($column === 'filter_sort_by' && isset($filterValues[$index])) {
                return $filterValues[$index];
            }
        }

        return null;
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('member_id', function (Review $item) {
                if (!$item->member_id) {
                    return $item->name . ' (Guest)';
                }
                return $item->member ? $item->member->name : $item->name;
            })
            ->editColumn('rating', function (Review $item) {
                return Html::tag('div', str_repeat('★', $item->rating) . str_repeat('☆', 5 - $item->rating), ['class' => 'text-warning']);
            })
            ->editColumn('is_approved', function (Review $item) {
                if ($item->is_approved) {
                     return Html::tag('span', 'Đã duyệt', ['class' => 'badge bg-success']);
                }
                return Html::tag('span', 'Chờ duyệt', ['class' => 'badge bg-warning']);
            })
            ->addColumn('operations', function (Review $item) {
                $action = '';
                
                // Add AI Analyze button for low ratings
                if ($item->rating <= 3) {
                    $action .= Html::tag('button', '<i class="ti ti-brain"></i> Phân tích AI', [
                        'class' => 'btn btn-info btn-sm me-1 btn-analyze-review',
                        'data-id' => $item->id,
                        'data-url' => route('reviews.analyze', $item->id),
                    ])->toHtml();
                }

                return $this->getOperations('reviews.edit', 'reviews.destroy', $item, $action);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->getModel()->query()->select([
            'id',
            'member_id',
            'name',
            'rating',
            'comment',
            'is_approved',
            'created_at',
        ]);

        // Custom Sort Logic: read from indexed filter arrays
        $sortValue = $this->getSortValueFromRequest();

        if ($sortValue) {
             switch ($sortValue) {
                 case 'newest':
                     $query->orderBy('created_at', 'desc');
                     break;
                 case 'oldest':
                     $query->orderBy('created_at', 'asc');
                     break;
                 case 'rating_desc':
                     $query->orderBy('rating', 'desc');
                     break;
                 case 'rating_asc':
                     $query->orderBy('rating', 'asc');
                     break;
             }
        } else {
            // Default sort: newest first
            $query->orderBy('created_at', 'desc');
        }

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            Column::make('member_id')->title('Người đánh giá'),
            Column::make('rating')->title('Đánh giá'),
            Column::make('comment')->title('Nội dung')->limit(50),
            DateColumn::make('created_at')->title('Ngày tạo'),
            Column::make('is_approved')->title('Trạng thái'),
        ];
    }

    public function buttons(): array
    {
        return [];
    }
    
}
