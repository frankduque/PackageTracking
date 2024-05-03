<x-app-layout x-data="app">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lista de Pacotes') }}
            </h2>
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'addPackageModal')">{{ __('Adicionar Pacotes') }}</x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($packages->isEmpty())
                        <div class="text-center text-2xl font-semibold mb-4">Nenhum pacote cadastrado.</div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Código</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Host</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Última Atualização</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach ($packages as $package)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $package->codigo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $package->host }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $package->updated_at->format('d/m/Y H:i:s') }}<br>{{ $package->lastEvent }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            <x-primary-button x-data
                                                @click="$dispatch('detailsmodal', { id: {{ $package->id }} })">Detalhes</x-primary-button>

                                            <form id="delete-form-{{ $package->id }}"
                                                action="{{ route('packages.destroy', $package) }}" method="POST"
                                                class="inline-block delete">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button
                                                    @click.prevent="deletePacket()">Excluir</x-danger-button>
                                            </form>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                        {{ $packages->links() }} <!-- Links de paginação -->
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<div x-data="{ content: { value: '' } }" @detailsmodal.window="showPackageDetails($event.detail.id, content)">
    <div x-html="content.value"></div>
</div>

@include('packages.partials.package-form')

<script>
    function deletePacket() {
        if (!confirm('Deseja realmente excluir este pacote?')) {
            event.preventDefault();
        }
    }

    function showPackageDetails(id, content) {

        content.value = 'Carregando...';
        fetch(`/packages/${id}/details`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar detalhes do pacote');
                }
                return response.text();
            })
            .then(data => {
                content.value = data;
            })
            .catch(error => {
                console.error('Erro:', error);
                content.value = 'Erro ao buscar detalhes do pacote';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form.delete').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Impede o envio do formulário

                var packageId = this.id.split('-')[
                2]; // Obtém o ID do pacote do ID do formulário

                Swal.fire({
                    title: 'Tem certeza?',
                    text: 'Esta ação não pode ser desfeita!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Se o usuário confirmar, envie o formulário
                        document.getElementById('delete-form-' + packageId).submit();
                    }
                });
            });
        });
    });
</script>
