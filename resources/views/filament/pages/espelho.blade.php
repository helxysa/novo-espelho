<x-filament::page class="">
    <div class="">
        <div class="">
            <div class="overflow-x-auto">
                <table class="w-full table-auto mx-10">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-12 py-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Município
                            </th>
                            <th scope="col" class="px-12 py-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Grupo Promotoria
                            </th>
                            <th scope="col" class="px-12 py-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Promotoria
                            </th>
                            <th scope="col" class="px-12 py-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Promotor
                            </th>
                            <th scope="col" class="px-12 py-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Período
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($promotorias as $promotoria)
                            <tr class="hover:bg-gray-50 transition-all duration-200 ease-in-out">
                                <td class="px-12 py-8 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $promotoria->municipio }}
                                </td>
                                <td class="px-12 py-8 whitespace-nowrap text-sm text-gray-700">
                                    {{ $promotoria->grupo_promotoria }}
                                </td>
                                <td class="px-12 py-8 whitespace-nowrap text-sm text-gray-700">
                                    {{ $promotoria->promotoria }}
                                </td>
                                <td class="px-12 py-8 whitespace-nowrap text-sm text-gray-700">
                                    {{ $promotoria->promotor }}
                                </td>
                                <td class="px-12 py-8 whitespace-nowrap text-sm text-gray-700">
                                    @include('filament.pages.components.Modal.ModalEvento', ['promotoria' => $promotoria])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament::page>