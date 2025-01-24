<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use \App\Models\Transaction;
use \App\Models\Category;


class StatsOverview extends BaseWidget
{

    public function difference()
    {
        $totalExpense = Transaction::Expenses()->get()->sum('amount');
        $totalIncome = Transaction::Incomes()->get()->sum('amount');
        $difference = $totalIncome - $totalExpense;
        $percentageDifference = ($totalIncome > 0) ? ($difference / $totalIncome) * 100 : 0;

        return $percentageDifference;
    }

    protected function getStats(): array
    {

        $totalExpense = Transaction::Expenses()->get()->sum('amount');
        $totalIncome = Transaction::Incomes()->get()->sum('amount');

        return [
            Stat::make('Expenses', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
                ->description('('. Transaction::Expenses()->count() .') expenses')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Incomes', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('('. Transaction::Incomes()->count() .') expenses')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Difference', 'Rp ' . number_format($totalIncome-$totalExpense, 0, ',', '.'))
                ->description(floor($this->difference()) . '% differences')
                ->color('success'),
        ];
    }
}
