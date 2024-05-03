<x-modal name="addPackageModal" :show="$errors->any()" focusable>

    <form action="{{ route('packages.store') }}" method="POST">
        @csrf
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Adicionar Pacotes') }}
        </h2>

        <div class="mb-4">
            <label for="codigos" class="block text-sm font-medium text-gray-200">Códigos (separados por virgula):</label>
            <input type="text" name="codigos" id="codigos" autocomplete="off" required
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

            <x-input-error :messages="$errors->all()" class="mt-2" />

         </div>
        <div class="mt-6 flex justify-end">

            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button class="ms-3">
                {{ __('Adicionar') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
