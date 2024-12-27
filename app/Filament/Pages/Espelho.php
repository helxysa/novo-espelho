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
use App\Http\Controllers\PlantaoUrgenciaController;
use App\Models\Historico; 
use App\Models\Periodo;


class Espelho extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
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
    public $plantoes;
    public $periodos;
    public $novo_periodo_inicio;
    public $novo_periodo_fim;
    public $preview = false;
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
        
        $plantaoController = new PlantaoUrgenciaController();
        $this->plantoes = $plantaoController->listarPlantaoUrgencia();

        $this->periodos = Periodo::all();
    }


    
    public function previewPeriodo()
    {
        $this->preview = true; 
    }

    public function cancelPreview()
    {
        $this->preview = false; 
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
    $this->validate(); // Validate all fields

    $latestPeriodo = Periodo::orderBy('id', 'desc')->first(); 
    if (!$latestPeriodo) {
        Notification::make()
            ->title('Erro ao salvar evento')
            ->body('Nenhum período disponível para associar ao evento.')
            ->danger()
            ->send();
        return;
    }

    \Log::info('Latest Periodo ID: ' . $latestPeriodo->id);

    $eventoController = new EventoController();
    $response = $eventoController->salvarEvento([
        'titulo' => $this->titulo,
        'tipo' => $this->tipo,
        'periodo_id' => $latestPeriodo->id, 
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
        $latestPeriodo = Periodo::orderBy('created_at', 'desc')->first();

        if (!$latestPeriodo) {
            Notification::make()
                ->title('Erro ao atualizar evento')
                ->body('Nenhum período disponível para associar ao evento.')
                ->danger()
                ->send();
            return;
        }

        $eventoController = new EventoController();
        $response = $eventoController->updateEvento($id, [
            'titulo' => $this->titulo,
            'tipo' => $this->tipo,
            'periodo_id' => $latestPeriodo->id, 
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



    public function adicionarPlantaoUrgente()
    {
        $this->validate([
            'periodo_inicio' => 'required|date',
            'periodo_fim' => 'required|date|after_or_equal:periodo_inicio',
            'promotor_designado' => 'required|exists:promotores,id',
        ]);

        // Get the period with the highest ID
        $latestPeriodo = Periodo::orderBy('id', 'desc')->first(); // Fetch the period with the highest ID

        if (!$latestPeriodo) {
            Notification::make()
                ->title('Erro ao adicionar plantão urgente')
                ->body('Nenhum período disponível para associar ao plantão.')
                ->danger()
                ->send();
            return;
        }

        $response = DB::table('plantao_atendimento')->insert([
            'periodo_inicio' => $this->periodo_inicio,
            'periodo_fim' => $this->periodo_fim,
            'promotor_designado_id' => $this->promotor_designado,
            'periodo_id' => $latestPeriodo->id, // Set the latest periodo_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Historico::create([
            'users_id' => auth()->id(),
            'detalhes' => 'Criou um novo plantão de urgência: ',
            'modificado' => now(),
        ]);

        if ($response) {
            Notification::make()
                ->title('Plantão urgente adicionado com sucesso!')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Erro ao salvar plantão urgente')
                ->body('Ocorreu um erro ao tentar salvar o plantão.')
                ->danger()
                ->send();
        }
    }

    

    public function deletePlantaoUrgente($plantaoId)
{
    try {
        DB::table('plantao_atendimento')->where('id', $plantaoId)->delete();

        Historico::create([
            'users_id' => auth()->id(),
            'detalhes' => 'Excluiu um plantão de urgência: ',
            'modificado' => now(),
        ]);

        Notification::make()
            ->title('Plantão excluído com sucesso!')
            ->success()
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->title('Erro ao excluir plantão')
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}

    

    public function getHeading(): string
    {
        return '';
    }

    public function adicionarPeriodo()
    {
        $this->validate([
            'novo_periodo_inicio' => 'required|date',
            'novo_periodo_fim' => 'required|date|after_or_equal:novo_periodo_inicio',
        ]);

        Periodo::create([
            'periodo_inicio' => $this->novo_periodo_inicio,
            'periodo_fim' => $this->novo_periodo_fim,
            'promotor_id' => auth()->id(), // Assuming you want to associate it with the logged-in user
        ]);

        // Reset the input fields
        $this->novo_periodo_inicio = null;
        $this->novo_periodo_fim = null;

        // Optionally, you can add a success message or redirect
    }

}