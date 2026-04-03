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
            <div
                class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col justify-between hover:border-blue-300 transition-all group">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <div class="truncate">
                            <h3 class="text-base font-bold text-gray-800 truncate" title="{{ $workflow->name }}">
                                {{ $workflow->name }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium">
                                Criado em: {{ \Carbon\Carbon::parse($workflow->created_at)->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $workflow->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $workflow->status }}
                            </span>
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

                                <div class="absolute right-2 flex items-center gap-1 bg-gray-50 pl-2">
                                    <button class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors"
                                        title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 text-gray-400 hover:text-red-500 transition-colors"
                                        title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full border-2 border-dashed border-gray-200 rounded-xl p-12 flex flex-col items-center justify-center">
                <div class="text-gray-300 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Nenhum workflow encontrado</p>
                <p class="text-sm text-gray-400">Você ainda não criou automações para este projeto.</p>
            </div>
        @endforelse
    </div>


</x-layouts.sistema>