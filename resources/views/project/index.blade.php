<x-layouts.sistema>

    <x-sistema.page-presentation icon="folder" page="Lista de Projetos">

        <x-slot:actions>
            <button id="btn-add-project"
                class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md transition-all duration-200 shadow-sm active:scale-95">
                <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                Adicionar
            </button>
        </x-slot:actions>

    </x-sistema.page-presentation>

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

        @forelse ($projects as $project)
            <x-sistema.project-component.list-project :id="$project->id" :name="$project->name"
                :createdAt="$project->created_at" :apiKey="$project->api_key" />

        @empty
            <div
                class="flex flex-col items-center justify-center p-8 text-center bg-white border-2 border-dashed border-gray-300 rounded-xl shadow-sm">
                <div class="p-3 bg-indigo-50 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-gray-900">Nenhum projeto encontrado</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-xs">
                    Você ainda não tem projetos ativos. Comece criando um agora para gerenciar seus dados.
                </p>
            
            </div>

        @endforelse

    </div>



    @push('script')
        @vite('resources/js/pages/project.js')
    @endpush


</x-layouts.sistema>