<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Http\Controllers\HistoricoController;

class Historico extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.historico';
    
    public function getLogs()
    {
        $historicoController = new HistoricoController();
        return $historicoController->historico();
    }
    
    protected function getViewData(): array
    {
        return [
            'logs' => $this->getLogs(),
        ];
    }
}