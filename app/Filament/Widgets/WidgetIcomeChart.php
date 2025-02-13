<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\Transactions;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class WidgetIcomeChart extends ChartWidget
{
    protected static ?string $heading = 'Pemasukan';
    protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::query(Transactions::query()->incomes())
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->sum('amount');
 
    return [
        'datasets' => [
            [
                'label' => 'Pemasukan per Hari',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
