<x-layouts.sistema>



    <x-sistema.page-presentation icon="bolt" page="Lista de Actions">

        <x-slot:actions>
            <a href="{{ route('workflow_action.create') }}">
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md transition-all duration-200 shadow-sm active:scale-95">
                    <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    Adicionar
                </button>
            </a>
        </x-slot:actions>

    </x-sistema.page-presentation>


    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#18181b'
                });
            });
        </script>
    @endif


    <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

        @forelse ($actions as $action)
            <x-sistema.workflow-action.list-workflow-action :action="$action" />
        @empty
            <div
                class="col-span-full border-2 border-dashed border-gray-200 rounded-xl p-12 flex flex-col items-center justify-center">
                <div class="text-gray-300 mb-3">
                    <i data-lucide="git-branch" class="w-8 h-8"></i>
                </div>
                <p class="text-gray-500 font-medium">Nenhum workflow encontrado</p>
                <p class="text-sm text-gray-400">Crie seu primeiro fluxo de automação para começar.</p>
            </div>
        @endforelse


    </div>



    @push('script')
        @vite('resources/js/pages/workflow_action-index.js')
    @endpush
</x-layouts.sistema>