<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Filament\Notifications;

class EventModal extends Component
{
    public $nome; // Campo para o nome do evento
    public $open = false; // Controle de visibilidade do modal

    protected $rules = [
        'nome' => 'required|string|max:255',
    ];

    public function saveEvent()
    {
        $this->validate();

        DB::transaction(function () {
            DB::table('eventos')->insert([
                'nome' => $this->nome,
                // outros campos...
            ]);
        });

        Notifications::success('Evento adicionado com sucesso!');
        $this->reset(); // Limpa os campos do formulário
        $this->emit('eventSaved'); // Emite um evento para fechar o modal
    }

    public function render()
    {
        return view('livewire.event-modal');
    }
}