<x-modal name="detailsModal" :show="true" focusable>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Detalhes do Pacote {{ $package->codigo }}
    </h2>
    <div class="mt-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-200">Código:</label>
                <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ $package->codigo }}</span>
            </div>
            <div>
                <label for="host" class="block text-sm font-medium text-gray-200">Host:</label>
                <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ $package->host }}</span>
            </div>
            <div>
                <label for="servico" class="block text-sm font-medium text-gray-200">Serviço:</label>
                <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ $package->servico }}</span>
            </div>
            <div>
                <label for="ultimo" class="block text-sm font-medium text-gray-200">Última Status:</label>
                <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ $package->ultimo }}</span>
            </div>
        </div>
    </div>
    <div class="mt-6">
        <div class="grid grid-cols-1 gap-4">
            @foreach ($package->packageEvent()->orderBy('data', 'desc')->get() as $event)
                <div class="bg-white dark:bg-gray-600 shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-md font-medium leading-6 text-gray-900 dark:text-gray-100">{{ $event->local }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">{{ $event->status }}</p>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">
                            {{ $event->data }}</p>

                        <!-- Exemplo de como exibir o sub_status -->
                        @if ($event->sub_status)
                            @foreach ($event->sub_status as $subStatus)
                                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">
                                    {{ $subStatus }}
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-modal>
