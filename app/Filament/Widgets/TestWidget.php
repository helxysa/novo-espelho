<?php

namespace App\Filament\Widgets;

use App\Models\Evento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Eventos', Evento::count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
