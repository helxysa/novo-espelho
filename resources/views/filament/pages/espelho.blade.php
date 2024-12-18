<x-filament::page class="bg-gray-50">
    <div class="p-6">
        @include('filament.pages.components.PlantaoUrgencia.PlantaoUrgencia')

        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
            <div class="bg-red-500 text-red p-4">Teste de cor</div>
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Município
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Grupo Promotoria
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Promotoria
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Promotor
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Eventos
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($promotorias->groupBy('promotor_id') as $promotoriasGroup)
                        <tr class="hover:bg-gray-50/50 transition-all duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $promotoriasGroup->first()->municipio }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $promotoriasGroup->first()->grupo_promotoria }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $promotoriasGroup->first()->promotoria }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $promotoriasGroup->first()->promotor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if ($promotoriasGroup->isEmpty())
                                    <x-filament::button
                                        wire:click="addEvento({{ $promotoriasGroup->first()->promotor_id }})"
                                        class="text-blue-500 hover:text-blue-700 transition-colors duration-150"
                                        size="sm"
                                    >
                                        Adicionar Evento
                                    </x-filament::button>
                                @else
                                    @foreach ($promotoriasGroup as $promotoria)
                                        <div class="flex items-center justify-between space-x-4 mb-2">
                                            <span class="flex-1">{{ $promotoria->evento }}</span>
                                            <x-filament::button
                                                wire:click="deleteEvento({{ $promotoria->evento_id }})"
                                                class="text-red-500 hover:text-red-700 transition-colors duration-150"
                                                size="sm"
                                                onclick="setTimeout(() => { location.reload(); }, 10);"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </x-filament::button>
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

