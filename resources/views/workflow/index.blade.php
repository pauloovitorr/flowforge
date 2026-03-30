<x-layouts.sistema>

  

    <x-sistema.page-presentation icon="network" page="Lista de Workflows">

        <x-slot:actions>
            <a href="{{ route('workflow.create') }}">
                <button id="btn-add-workflow"
                class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md transition-all duration-200 shadow-sm active:scale-95">
                <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                Adicionar
            </button>
            </a>
        </x-slot:actions>

    </x-sistema.page-presentation>

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

        <h1>Desenvolvimento</h1>

    </div>


</x-layouts.sistema>