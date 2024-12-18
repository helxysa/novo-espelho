<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\TestWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            TestWidget::class,
        ];
    }
}
