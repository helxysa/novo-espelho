<x-filament::page class="bg-gray-50 dark:bg-gray-800 ">
<div class="mt-8 bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden w-full"> 
        <div class="flex justify-center mt-4">
            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg shadow w-1/2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adicionar Período:</label>
                <div class="mt-2">
                    <input type="date" wire:model="novo_periodo_inicio" required class="mt-1 block w-full dark:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <input type="date" wire:model="novo_periodo_fim" required class="mt-1 block w-full dark:bg-gray-700 rounded-md border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <button wire:click="adicionarPeriodo" class="mt-4 bg-blue-500 dark:bg-blue-600 text-white rounded-md px-4 py-2">Adicionar Período</button>
            </div>
        </div>
  

        @include('filament.pages.components.PlantaoUrgencia.PlantaoUrgencia', ['plantoes' => $this->plantoes])

        <div class="space-y-6 p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
        
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
       <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Eventos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead>
                        <tr>
                   <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-white">
                                Município
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-50 dark:bg-gray-600 dark:text-white">
                                Grupo Promotoria
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-50 dark:bg-gray-600 dark:text-white">
                                Promotoria
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-50 dark:bg-gray-600 dark:text-white">
                                Membro
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-50 dark:bg-gray-600 dark:text-white">
                                Eventos
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                        @foreach ($promotorias->groupBy('promotor_id') as $promotoriasGroup)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $promotoriasGroup->first()->municipio }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $promotoriasGroup->first()->grupo_promotoria }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $promotoriasGroup->first()->promotoria }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $promotoriasGroup->first()->promotor }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($promotoriasGroup->isEmpty())
                                    <button
                                        wire:click="addEvento({{ $promotoriasGroup->first()->promotor_id }})"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg shadow hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150"
                                    >
                                        Adicionar <span class="ml-1">+</span>
                                    </button>
                                @else
                                    @foreach ($promotoriasGroup as $promotoria)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-600 rounded-lg mb-2">
                                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $promotoria->evento }}</span>
                                            @if($promotoria->evento)
                                                <div class="flex space-x-2">
                                                    @include('filament.pages.components.Modal.EditModalEvento', ['evento' => $promotoria])
                                                    <button
                                                        wire:click="deleteEvento({{ $promotoria->evento_id }})"
                                                        onclick="setTimeout(() => { location.reload(); }, 10);"
                                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-500"
                                                    >
                                                        Excluir
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @include('filament.pages.components.Modal.ModalEvento', ['promotoria' => $promotoria])
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament::page>
<script>
    function updateEndDate() {
        const startDate = document.getElementById('periodo_inicio').value;
        const endDateInput = document.getElementById('periodo_fim');
        if (startDate) {
            endDateInput.value = startDate; // Define a data final como a data inicial
        }
    }

    function highlightDates() {
        const startDate = document.getElementById('periodo_inicio').value;
        const endDateInput = document.getElementById('periodo_fim');
        if (startDate) {
            endDateInput.classList.add('bg-blue-100'); // Adiciona uma classe para destacar
        }
    }
</script>

