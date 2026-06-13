<x-layouts.sistema>

    {{-- Cabeçalho da Página --}}
    <x-sistema.page-presentation icon="network" page="Detalhes do Workflow: {{ $workflow->name }}">
        <x-slot:actions>
            <div class="flex items-center gap-3">
                <a href="{{ route('workflow.index') }}">
                    <button
                        class="group flex items-center gap-2 px-4 py-2 bg-white border border-zinc-200 text-zinc-700 text-sm font-medium rounded-lg shadow-sm hover:border-zinc-400 hover:text-zinc-900 transition-all duration-200 active:scale-95">
                        <i data-lucide="arrow-left"
                            class="w-4 h-4 text-zinc-500 group-hover:-translate-x-1 transition-transform"></i>
                        <span>Voltar</span>
                    </button>
                </a>
                <a href="{{ route('workflow.edit', $workflow->id) }}">
                    <button
                        class="flex items-center gap-2 px-4 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-black transition-all duration-200 active:scale-95">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                        <span>Editar Estrutura</span>
                    </button>
                </a>
            </div>
        </x-slot:actions>
    </x-sistema.page-presentation>

    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">

        {{-- COLUNA DA ESQUERDA: Linha do Tempo / Esteira de Execução --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-zinc-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-semibold text-zinc-800">Esteira de Execução</h3>
                        <p class="text-xs text-zinc-500 mt-0.5">Ordem sequencial em que as ações serão disparadas pelo
                            sistema.</p>
                    </div>
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $workflow->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-zinc-100 text-zinc-600 border border-zinc-200' }}">
                        {{ $workflow->status === 'active' ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                {{-- Linha do tempo visual --}}
                <div class="relative pl-6 border-l-2 border-zinc-200 space-y-8 ml-3 my-4">

                    {{-- GATILHO DA REQUISIÇÃO (TRIGGER) --}}
                    <div class="relative">
                        <div
                            class="absolute -left-[35px] top-0.5 bg-cyan-500 text-white p-1.5 rounded-full ring-4 ring-white shadow-sm flex items-center justify-center">
                            <i data-lucide="zap" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-cyan-600 uppercase tracking-wider block">Trigger
                                Raiz</span>
                            <h4 class="text-md font-bold text-zinc-800 mt-0.5">Disparo do Evento Externo</h4>
                            <div
                                class="mt-2 inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-zinc-900 text-cyan-400 border border-zinc-800">
                                {{ $workflow->trigger_event }}
                            </div>
                        </div>
                    </div>

                    {{-- MAPEAR ACTIONS DO WORKFLOW --}}
                    @forelse($workflow->actions as $index => $action)
                        <div class="relative">
                            {{-- Contador do Passo --}}
                            <div
                                class="absolute -left-[35px] top-1 bg-zinc-800 text-white w-7 h-7 flex items-center justify-center text-xs font-bold rounded-full ring-4 ring-white shadow-sm">
                                {{ $index + 1 }}
                            </div>

                            <div
                                class="bg-zinc-50 border border-zinc-200 rounded-xl p-4 flex items-center justify-between hover:bg-zinc-100/50 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="p-3 rounded-xl {{ $action->type === 'email' ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600' }}">
                                        <i data-lucide="{{ $action->type === 'email' ? 'mail' : 'globe' }}"
                                            class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-zinc-800 text-sm">
                                            {{ $action->type === 'email' ? 'Enviar Disparo de E-mail' : 'Chamada de Webhook / API' }}
                                        </h5>
                                        <p class="text-xs text-zinc-500 mt-0.5 font-mono">
                                            @if($action->type === 'email')
    Template: {{ $action->email->subject ?? 'Sem assunto definido' }}
@else
    [{{ $action->config_api['method'] ?? 'POST' }}] {{ Str::limit($action->config_api['url'] ?? 'Sem URL configurada', 45) }}
@endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs text-zinc-400 font-medium">ID: #{{ $action->id }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="relative text-zinc-400 italic text-sm py-4">
                            Nenhuma ação configurada para este fluxo ainda. Vá em editar para adicionar disparos!
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- COLUNA DA DIREITA: Documentação de Integração da API Mestre --}}
        <div class="lg:col-span-1">
            <div
                class="bg-zinc-950 text-zinc-100 border border-zinc-800 rounded-xl p-5 shadow-lg space-y-5 sticky top-6">
                <div>
                    <h3 class="text-base font-semibold text-white">Como disparar este fluxo?</h3>
                    <p class="text-xs text-zinc-400 mt-1">Envie uma requisição HTTP POST para a nossa API global
                        contendo a estrutura abaixo.</p>
                </div>

                {{-- Método e Endpoint --}}
                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider block">Endpoint</span>
                    <div
                        class="flex items-center gap-2 bg-zinc-900 px-3 py-2 rounded-lg border border-zinc-800 font-mono text-xs overflow-x-auto">
                        <span class="text-emerald-400 font-bold">POST</span>
                        <span class="text-zinc-300">https://api.flowforge.com/v1/events</span>
                    </div>
                </div>

                {{-- Headers Autenticados --}}
                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider block">Headers
                        obrigatórios</span>
                    <pre
                        class="bg-zinc-900 p-3 rounded-lg border border-zinc-800 font-mono text-[11px] text-zinc-300 leading-relaxed overflow-x-auto">Authorization: Bearer {{ $workflow->project->api_key ?? 'sua_api_key_aqui' }}
Content-Type: application/json</pre>
                </div>

                {{-- Payload JSON Dinâmico --}}
                
<div class="space-y-1.5">
    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider block">Payload JSON Esperado</span>
    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-800 relative">
        <div class="absolute top-2.5 right-2.5 text-[9px] bg-cyan-500/10 text-cyan-400 px-2 py-0.5 rounded border border-cyan-500/20 font-bold font-sans">
            JSON
        </div>
        <pre class="font-mono text-[11px] text-cyan-400 leading-relaxed overflow-x-auto"><code>{
    "event": "{{ $workflow->trigger_event }}",
    "payload": {
@if(count($variaveisMapeadas) > 0)
@foreach($variaveisMapeadas as $index => $var)
        "{{ $var }}": "valor_exemplo"{{ $index < count($variaveisMapeadas) - 1 ? ',' : '' }}
@endforeach
@endif
    }
}</code></pre>
    </div>
</div>

                <div class="bg-zinc-900/60 border border-zinc-800/80 rounded-lg p-3">
                    <p class="text-[11px] text-zinc-400 leading-relaxed italic">
                        <span class="text-amber-400 font-semibold">Nota:</span> O FlowForge capturará as chaves
                        informadas no objeto <code class="text-white font-mono">"payload"</code> e preencherá as suas
                        variáveis dinâmicas de e-mail e requisições automaticamente.
                    </p>
                </div>
            </div>
        </div>

    </div>

</x-layouts.sistema>