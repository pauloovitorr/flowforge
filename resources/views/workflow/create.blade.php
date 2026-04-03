<x-layouts.sistema>

    @push('style')
        @vite('resources/css/pages/workflow.css')
    @endpush

    @if ($errors->any())
        <script>

            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops! Verifique os dados',
                    html: `
                                    <ul style="text-align: center;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                `,
                    confirmButtonColor: '#18181b',
                });
            });
        </script>
    @endif



    <div class="w-full grid grid-cols-1">
        <x-sistema.page-presentation icon="network" page="Novo Workflow">

            <x-slot:actions>

                <a href="{{ route('workflow.index') }}">
                    <button id="btn-back-workflow"
                        class="group flex items-center gap-2 px-4 py-2 bg-white border border-zinc-200 text-zinc-700 text-sm font-medium rounded-lg shadow-sm hover:border-zinc-400 hover:text-zinc-900 hover:shadow-md transition-all duration-200 active:scale-95 focus:ring-2 focus:ring-zinc-100 outline-none">

                        <i data-lucide="arrow-left"
                            class="w-4 h-4 text-zinc-500 group-hover:-translate-x-1 transition-transform duration-200">
                        </i>

                        <span>Voltar</span>
                    </button>
                </a>

            </x-slot:actions>

        </x-sistema.page-presentation>


        <div class="bg-white border border-zinc-200 rounded-xl shadow-sm">
            <form action="{{ route('workflow.store') }}" method="post" id="form-workflow" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Campo Nome --}}
                    <div class="flex flex-col gap-1">
                        <label for="w-name" class="text-sm font-medium text-zinc-700">Nome do Workflow <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="w-name" name="name" value="{{ old('name') }}"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            placeholder="Ex: Automação de Boas-vindas" required>
                    </div>

                    {{-- Campo Projeto --}}
                    <div class="flex flex-col gap-1">
                        <label for="project_id" class="text-sm font-medium text-zinc-700">Projeto <span
                                class="text-red-600">*</span></label>
                        <select id="project_id" name="project_id"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            required>
                            <option value=""></option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Campo Trigger Event --}}
                    <div class="flex flex-col gap-1">
                        <label for="w-event" class="text-sm font-medium text-zinc-700">Evento de Gatilho (Trigger) <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="w-event" name="trigger_event" value="{{ old('trigger_event') }}"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            placeholder="Ex: user.registered" required>
                    </div>

                    {{-- Campo Status --}}
                    <div class="flex flex-col gap-1">
                        <label for="w-status" class="text-sm font-medium text-zinc-700">Status <span
                                class="text-red-600">*</span></label>
                        <select id="w-status" name="status"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                </div>

                {{-- Campo Descrição (Textarea não usa atributo value, o conteúdo vai entre as tags) --}}
                <div class="flex flex-col gap-1">
                    <label for="w-desc" class="text-sm font-medium text-zinc-700">Descrição do Workflow</label>
                    <textarea id="w-desc" name="description" rows="2"
                        class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                        placeholder="Explique o que este workflow executa..."
                        maxlength="255">{{ old('description') }}</textarea>
                </div>

                <div class="pt-6 flex justify-end items-center gap-4">
                    <button type="button" onclick="window.history.back()"
                        class="text-sm font-medium text-zinc-600 hover:text-zinc-900">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-save-workflow"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-zinc-900 rounded-lg hover:bg-black transition-all shadow-sm">
                        Salvar Workflow
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        @vite('resources/js/pages/workflow.js')
    @endpush
</x-layouts.sistema>