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
        @forelse ($workflows as $workflow)
            <x-sistema.workflow-component.list-workflow :id="$workflow->id" :name="$workflow->name"
                :project="$workflow->project" :trigger-event="$workflow->trigger_event" :status="$workflow->status"
                :description="$workflow->description" :created-at="$workflow->created_at" :actions="$workflow->actions" />
        @empty
            <div
                class="col-span-full border-2 border-dashed border-gray-200 rounded-xl p-12 flex flex-col items-center justify-center">
                <div class="text-gray-300 mb-3">
                    <i data-lucide="network"></i>
                </div>
                <p class="text-gray-500 font-medium">Nenhum workflow encontrado</p>
                <p class="text-sm text-gray-400">Você ainda não criou automações.</p>
            </div>
        @endforelse
    </div>



    @push('script')
        @vite('resources/js/pages/workflow.js')
    @endpush
</x-layouts.sistema>