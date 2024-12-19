<?php

namespace App\Filament\Widgets;

use App\Models\Evento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $chart = Evento::count();
        return [
            Stat::make('Total de Eventos', Evento::count())
                ->description('Todos os eventos cadastrados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([$chart - 4, $chart + ($chart + 1),$chart + ($chart + 2), $chart + ($chart + 3)])
                ->color('success'),
        ];
    }
}

