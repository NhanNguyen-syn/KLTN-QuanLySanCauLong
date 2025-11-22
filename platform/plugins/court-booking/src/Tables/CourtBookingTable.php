<?php

namespace Botble\CourtBooking\Tables;

use Botble\CourtBooking\Models\CourtBooking;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CourtBookingTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(CourtBooking::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('court-booking.create'))
            ->addActions([
                EditAction::make()->route('court-booking.edit'),
                DeleteAction::make()->route('court-booking.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('court-booking.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('court-booking.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                ]);
            });
    }
}
