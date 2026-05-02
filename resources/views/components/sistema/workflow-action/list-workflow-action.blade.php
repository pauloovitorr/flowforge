@props(['action'])

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col justify-between group h-full"
    data-id="{{ $action->id }}">
    
    <div>
        <!-- Cabeçalho: Contexto do Workflow -->
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-zinc-100 text-zinc-500 p-1.5 rounded-lg">
                <i data-lucide="git-branch" class="w-3 h-3"></i>
            </span>
            <div class="flex flex-col">
                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-tight leading-none">Workflow</span>
                <p class="text-xs font-semibold text-gray-700 truncate max-w-[150px]">
                    {{ $action->workflow->name }}
                </p>
            </div>
            <span class="ml-auto px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-black uppercase">
                {{ $action->workflow->trigger_event }}
            </span>
        </div>

        <!-- Título Principal: O que a Action faz -->
        <div class="flex justify-between items-start mb-4">
            <div class="truncate">
                <div class="flex gap-2 items-center">
                    <h3 class="text-base font-bold text-gray-800">
                        @if($action->type === 'api')
                            Chamada de API
                        @else
                            Envio de E-mail
                        @endif
                    </h3>
                    <p class="text-[11px] text-gray-400 font-medium">
                        • {{ $action->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="flex gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-100 opacity-0 group-hover:opacity-100 transition-opacity">
                <button title="Editar" class="p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                </button>
                <button title="Excluir" class="p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-red-600 transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Detalhamento Técnico -->
    <div class="mt-auto">
        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 relative overflow-hidden">
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 block">
                Dados da Configuração
            </span>
            
            <div class="flex flex-col gap-1">
                @if($action->type === 'api')
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-1 rounded">{{ $action->config_api['method'] ?? 'POST' }}</span>
                        <code class="text-[11px] text-gray-600 font-mono truncate pr-2">
                            {{ $action->config_api['url'] ?? 'URL não definida' }}
                        </code>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <i data-lucide="mail-check" class="w-3 h-3 text-blue-500"></i>
                        <span class="text-[11px] text-gray-600">ID do Template: <strong>#{{ $action->email_id }}</strong></span>
                    </div>
                @endif
            </div>

            <!-- Badge de Tipo no canto inferior -->
            <div class="absolute top-2 right-2">
                <i data-lucide="{{ $action->type === 'api' ? 'webhook' : 'mail' }}" class="w-4 h-4 text-gray-200"></i>
            </div>
        </div>
    </div>
</div>