<x-filament-panels::page>
    <div class="space-y-6">
        @foreach($logs as $log)
            <div class="p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 border bg-red-50 border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-red-700 font-semibold text-lg">{{ substr($log->nome_usuario, 0, 1) }}</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $log->nome_usuario }}</div>
                            <div class="text-sm text-red-600">{{ $log->action }}</div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                        {{ $log->modificado }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>