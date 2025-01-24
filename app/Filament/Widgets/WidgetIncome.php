<?php

namespace App\Filament\Widgets;


use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class WidgetIncome extends ChartWidget
{   
    protected static ?string $heading = 'Incomes';

    protected function getData(): array
    {                       
        $data = Trend::query(Transaction::Incomes())
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perMonth()
                ->sum('amount');
 
        return [
            'datasets' => [
                [
                    'label' => 'IDR',
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
