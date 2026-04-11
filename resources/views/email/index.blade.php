<x-layouts.sistema>

    <x-sistema.page-presentation icon="mail" page="Lista de Templates de E-mails">
        <x-slot:actions>
            <a href="{{ route('email.create') }}">
                <button id="btn-add-email"
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
        @forelse ($emails as $email)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col justify-between group"
                data-id="{{ $email->id }}">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <div class="truncate">
                            <div class="flex gap-2 items-center justify-between">
                                <h3 class="text-base font-semibold text-gray-800 truncate" title="{{ $email->name }}">
                                    {{ $email->name }}
                                </h3>
                                <span class="text-gray-300">-</span>
                                <p class="text-[11px] text-gray-400 font-medium">
                                    {{ \Carbon\Carbon::parse($email->created_at)->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="flex gap-2 items-center justify-between">
                                <p class="text-[11px] text-gray-400 font-medium">Autor:
                                    <span class="text-gray-500">{{ $email->user->name ?? 'Sistema' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-100">
                                <a href="{{ route('email.edit', $email->id) }}">
                                    <button title="Editar"
                                        class="p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    </button>
                                </a>
                                <form action="{{ route('email.destroy', $email->id) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" title="Excluir"
                                        class="btn-excluir-email p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-red-600 transition-all">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 relative">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                Prévia do texto
                            </span>
                            <div class="flex justify-between items-center">
                                <code class="text-xs text-gray-600 font-mono truncate pr-6">
                                     {{ strip_tags($email->body) ?? 'Template sem conteúdo definido.' }}
                                    </code>

                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-blue-600">
                                    Template
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
                    <i data-lucide="mail" class="w-8 h-8"></i>
                </div>
                <p class="text-gray-500 font-medium">Nenhum template encontrado</p>
                <p class="text-sm text-gray-400">Comece adicionando seu primeiro modelo de e-mail.</p>
            </div>
        @endforelse
    </div>

    @push('script')
        <script>
            // Exemplo de lógica para o botão de excluir
            document.querySelectorAll('.btn-excluir-email').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Excluir template?',
                        text: "Esta ação não pode ser desfeita.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#18181b',
                        cancelButtonColor: '#f44336',
                        confirmButtonText: 'Sim, excluir',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
        @vite('resources/js/pages/workflow.js')
    @endpush

</x-layouts.sistema>