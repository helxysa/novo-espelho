<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\Plantoes;
use App\Filament\Widgets\EventosPromotor;
use App\Filament\Widgets\PromotoresLicenca;
class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Painel de Controle';
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard';
    protected function getHeaderWidgets(): array
    {
        return [
            Plantoes::class,
            EventosPromotor::class,
          
        ];


    }

    
    public function getHeading(): string
    {
        return '';
    }
}
