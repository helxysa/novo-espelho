<?php

namespace App\Filament\Pages;

use App\Models\Municipio;
use App\Models\Evento;
use App\Models\Promotor;
use App\Models\Promotoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use App\Http\Controllers\PromotoriaController;
use App\Http\Controllers\EventoController;

class Espelho extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Painel de Controle';

    protected static string $view = 'filament.pages.espelho';

    public $promotorias;
    public $titulo;
    public $tipo;
    public $periodo_inicio;
    public $periodo_fim;
    public $promotor_designado;
    public $promotor_titular;
    public $promotoria_id;
    public $is_urgente = false;
    public $isModalOpen = false;
    public $editingEvento = null;

    protected $rules = [
        'titulo' => 'required',
        'tipo' => 'required',
        'periodo_inicio' => 'required|date',
        'periodo_fim' => 'required|date',
        'promotor_titular' => 'required',
        'promotor_designado' => 'required',
        'promotoria_id' => 'required'
    ];

    public function mount()
    {
        $promotoriaController = new PromotoriaController();
        $this->promotorias = $promotoriaController->getPromotorias();
    }

    public function setPromotorTitular($promotorId, $promotoriaId)
{
    $this->promotor_titular = $promotorId;
    $this->promotoria_id = $promotoriaId;
}

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->editingEvento = null;
        $this->reset([
            'titulo',
            'tipo',
            'periodo_inicio',
            'periodo_fim',
            'promotor_designado',
            'promotor_titular',
            'promotoria_id',
            'is_urgente'
        ]);
    }

    public function deleteEvento($id)
    {
        try {
            $eventoController = new EventoController();
            $eventoController->deleteEvento($id);
    
            Notification::make()
                ->title('Evento excluído com sucesso')
                ->success()
                ->send();
    
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erro ao excluir evento')
                ->danger()
                ->send();
        }
    }


    public function salvarEvento()
{
    $eventoController = new EventoController();
    $response = $eventoController->salvarEvento([
        'titulo' => $this->titulo,
        'tipo' => $this->tipo,
        'periodo_inicio' => $this->periodo_inicio,
        'periodo_fim' => $this->periodo_fim,
        'promotor_titular' => $this->promotor_titular,
        'promotor_designado' => $this->promotor_designado,
        'promotoria_id' => $this->promotoria_id,
        'is_urgente' => $this->is_urgente,
    ]);

    
    

    if ($response['status'] === 'success') {
        $this->reset(['titulo', 'tipo', 'periodo_inicio', 'periodo_fim', 'promotor_designado', 'promotor_titular']);
        Notification::make()
            ->title($response['message'])
            ->success()
            ->send();
    } else {
        Notification::make()
            ->title('Erro ao salvar evento')
            ->body($response['message'])
            ->danger()
            ->send();
    } 
}

    public function updateEvento($id)
    {
        $eventoController = new EventoController();
        $response = $eventoController->updateEvento($id, [
            'titulo' => $this->titulo,
            'tipo' => $this->tipo,
            'periodo_inicio' => $this->periodo_inicio,
            'periodo_fim' => $this->periodo_fim,
            'promotor_titular' => $this->promotor_titular,
            'promotor_designado' => $this->promotor_designado,
            'promotoria_id' => $this->promotoria_id,
            'is_urgente' => $this->is_urgente,
        ]);

        if ($response['status'] === 'success') {
            $this->reset(['titulo', 'tipo', 'periodo_inicio', 'periodo_fim', 'promotor_designado', 'promotor_titular']);
            Notification::make()
                ->title($response['message'])
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Erro ao atualizar evento')
                ->body($response['message'])
                ->danger()
                ->send();
        } 
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function editEvento($eventoId)
    {
        $evento = DB::table('eventos')->where('id', $eventoId)->first();
        
        $this->editingEvento = $evento;
        $this->titulo = $evento->titulo;
        $this->tipo = $evento->tipo;
        $this->periodo_inicio = $evento->periodo_inicio;
        $this->periodo_fim = $evento->periodo_fim;
        $this->promotor_titular = $evento->promotor_titular_id;
        $this->promotor_designado = $evento->promotor_designado_id;
        $this->promotoria_id = $evento->promotoria_id;
        $this->is_urgente = $evento->is_urgente;
    }

    public function cancelEdit()
    {
        $this->editingEvento = null;
        $this->reset([
            'titulo',
            'tipo',
            'periodo_inicio',
            'periodo_fim',
            'promotor_designado',
            'promotor_titular',
            'promotoria_id',
            'is_urgente'
        ]);
    }

    public function setEventoParaEditar($eventoId)
    {
        $evento = DB::table('eventos')->where('id', $eventoId)->first();
        
        $this->editingEvento = $evento;
        $this->titulo = $evento->titulo;
        $this->tipo = $evento->tipo;
        $this->periodo_inicio = $evento->periodo_inicio;
        $this->periodo_fim = $evento->periodo_fim;
        $this->promotor_titular = $evento->promotor_titular_id;
        $this->promotor_designado = $evento->promotor_designado_id;
        $this->promotoria_id = $evento->promotoria_id;
        $this->is_urgente = $evento->is_urgente;
    }

    public function addEvento($promotorId)
    {
        $this->reset([
            'titulo',
            'tipo',
            'periodo_inicio',
            'periodo_fim',
            'promotor_designado',
            'is_urgente',
            'editingEvento'
        ]);
        
        $this->promotor_titular = $promotorId;
    }

   
}