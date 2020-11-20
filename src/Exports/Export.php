<?php

namespace TypiCMS\Modules\Subscriptions\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class Export implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Subscription::class)
            ->selectFields($request->input('fields.subscriptions'))
            ->allowedSorts(['plan', 'created_at'])
            ->allowedFilters([
                AllowedFilter::custom('plan', new FilterOr()),
            ])
            ->get();
    }

    public function map($user): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $user->name,
            $user->plan,
            $user->tax_percentage,
            Date::dateTimeToExcel($user->ends_at),
            Date::dateTimeToExcel($user->trial_ends_at),
            Date::dateTimeToExcel($user->cycle_started_at),
            Date::dateTimeToExcel($user->cycle_ends_at),
            $user->scheduled_order_item_id,
        ];
    }

    public function headings(): array
    {
        return [
            'Created at',
            'Updated at',
            'Name',
            'Plan',
            'Tax percentage',
            'Ends at',
            'Trial ends at',
            'Cycle started at',
            'Cycle ends at',
            'Scheduled order item id',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'F' => NumberFormat::FORMAT_DATE_DATETIME,
            'G' => NumberFormat::FORMAT_DATE_DATETIME,
            'H' => NumberFormat::FORMAT_DATE_DATETIME,
            'I' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
