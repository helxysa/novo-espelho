<x-filament::page id="PlantaoUrgencia" width="md">
    <div class="space-y-6 p-4 bg-white rounded-lg shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800">Entrância Final – Macapá</h2>
        <div class="grid gap-4">
            <div class="flex flex-col space-y-2">
                <label class="font-medium text-gray-700">Nome do Promotor:</label>
                <select class="rounded-lg border-gray-300 w-full">
                    <option>Selecione o promotor</option>
                </select>
            </div>
            <div class="flex flex-col space-y-2">
                <label class="font-medium text-gray-700">Período:</label>
                <input type="text" placeholder="Selecione o período" class="rounded-lg border-gray-300 w-full">
            </div>
            <div class="flex space-x-2 pt-2">
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center">
                    Adicionar +
                </button>
            </div>
        </div>
    </div>
</x-filament::page>