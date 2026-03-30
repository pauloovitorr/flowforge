<x-layouts.sistema>

    @push('style')
        @vite('resources/css/pages/workflow.css')
    @endpush

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
            <form id="form-workflow" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-1">
                        <label for="w-name" class="text-sm font-medium text-zinc-700">Nome do Workflow</label>
                        <input type="text" id="w-name" name="name"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            placeholder="Ex: Automação de Boas-vindas">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="project" class="text-sm font-medium text-zinc-700">Projeto</label>
                        <select id="project" name="project" class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all">
                            <option value=""></option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

            
                    <div class="flex flex-col gap-1">
                        <label for="w-event" class="text-sm font-medium text-zinc-700">Evento de Gatilho
                            (Trigger)</label>
                        <input type="text" id="w-event" name="trigger_event"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            placeholder="Ex: user.registered">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="w-status" class="text-sm font-medium text-zinc-700">Status</label>
                        <select id="w-status" name="status"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="w-desc" class="text-sm font-medium text-zinc-700">Descrição do Workflow</label>
                    <textarea id="w-desc" name="description" rows="2"
                        class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                        placeholder="Explique o que este workflow executa..."></textarea>
                </div>

                <div class="pt-6  flex justify-end items-center gap-4">
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