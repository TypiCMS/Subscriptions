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
    public function collection()
    {
        return QueryBuilder::for(Subscription::class)
            ->allowedSorts(['plan', 'created_at'])
            ->allowedFilters([
                AllowedFilter::custom('plan', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->name,
            $model->plan,
            $model->tax_percentage,
            Date::dateTimeToExcel($model->ends_at),
            Date::dateTimeToExcel($model->trial_ends_at),
            Date::dateTimeToExcel($model->cycle_started_at),
            Date::dateTimeToExcel($model->cycle_ends_at),
            $model->scheduled_order_item_id,
        ];
    }

    public function headings(): array
    {
        return [
            __('Created at'),
            __('Updated at'),
            __('Name'),
            __('Plan'),
            __('Tax percentage'),
            __('Ends at'),
            __('Trial ends at'),
            __('Cycle started at'),
            __('Cycle ends at'),
            __('Scheduled order item id'),
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
}
