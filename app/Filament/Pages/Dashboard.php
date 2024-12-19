<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\TestWidget;
use App\Filament\Widgets\EventosPromotor;
use App\Filament\Widgets\PromotoresLicenca;
class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Painel de Controle';
    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            TestWidget::class,
            EventosPromotor::class,
            PromotoresLicenca::class,
        ];
    }
}
