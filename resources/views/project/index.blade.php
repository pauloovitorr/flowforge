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
                class="col-span-full border-2 border-dashed border-gray-200 rounded-xl p-12 flex flex-col items-center justify-center">
                <div class="text-gray-300 mb-3">
                    <i data-lucide="folder"></i>
                </div>
                <p class="text-gray-500 font-medium">Nenhum projeto encontrado</p>
                <p class="text-sm text-gray-400"> Você ainda não tem projetos ativos. Comece criando um agora mesmo!</p>
            </div>

        @endforelse



    </div>



    @push('script')
        @vite('resources/js/pages/project.js')
    @endpush


</x-layouts.sistema>