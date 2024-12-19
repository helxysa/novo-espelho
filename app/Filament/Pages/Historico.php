<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Http\Controllers\HistoricoController;

class Historico extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Painel de Controle';
    protected static string $view = 'filament.pages.historico';
    
    public $search = '';
    public $filter = '';
    
    public function getLogs()
    {
        $historicoController = new HistoricoController();
        return $historicoController->historico($this->search, $this->filter);
    }
    
    protected function getViewData(): array
    {
        return [
            'logs' => $this->getLogs(),
        ];
    }
}