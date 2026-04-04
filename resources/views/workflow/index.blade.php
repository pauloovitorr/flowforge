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
            <div class="workflow bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col justify-between group"
                data-id="{{ $workflow->id }}">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <div class="truncate">

                            <div class="flex gap-2 items-center justify-between">
                                <h3 class="text-base font-semibold text-gray-800 truncate" title="{{ $workflow->name }}">
                                    {{ $workflow->name }}
                                </h3>
                                -
                                <p class="text-[11px] text-gray-400 font-medium">
                                    {{\Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') }}
                                </p>
                            </div>


                            <div class="flex gap-2 items-center justify-between">
                                <p class="text-[11px] text-gray-400 font-medium">Projeto:
                                    {{ $workflow->project->name ?? 'Sem Projeto' }}
                                </p>
                            </div>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="flex gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-100">
                                <a href="{{ route('workflow.edit', [$workflow->id]) }}">
                                    <button title="Editar"
                                        class="btn-editar p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    </button>
                                </a>
                                <button title="Excluir"
                                    class="btn-excluir p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-red-600 transition-all">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>


                        </div>
                    </div>

                    <p class="text-sm text-gray-500 line-clamp-2 mb-4 leading-relaxed">
                        {{ $workflow->description ?? 'Sem descrição definida para este workflow.' }}
                    </p>
                </div>

                <div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 relative">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Trigger
                                Event</span>
                            <div class="flex justify-between items-center">
                                <code class="text-xs text-gray-600 font-mono truncate pr-6">
                                                                                        {{ $workflow->trigger_event }}
                                                                                    </code>

                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $workflow->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ $workflow->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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