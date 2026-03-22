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

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-3 gap-4">

        @foreach ($projects as $project)
            <x-sistema.project-component.list-project 
            :id="$project->id" 
            :name="$project->name"
            :createdAt="$project->created_at" 
            :apiKey="$project->api_key" 
            />
        @endforeach

    </div>



    @push('script')
        @vite('resources/js/pages/project.js')
    @endpush


</x-layouts.sistema>