@props([
    'id',
    'name',
    'createdAt',
    'project' => null,
    'description' => null,
    'triggerEvent',
    'status' => 'inactive',
    'actions' => []
])

<div class="workflow bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col justify-between group hover:border-zinc-400 hover:shadow-md transition-all duration-200"
    data-id="{{ $id }}">
    <div>
        {{-- Cabeçalho do Card (Título e Botões de Ação) --}}
        <div class="flex justify-between items-start mb-3">
            <div class="truncate flex-1 pr-2">
                {{-- O clique no Nome do Workflow leva para a Show --}}
                <a href="{{ route('workflow.show', $id) }}" class="block group/title">
                    <div class="flex gap-2 items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-800 truncate group-hover/title:text-cyan-600 transition-colors" title="{{ $name }}">
                            {{ $name }}
                        </h3>
                    </div>
                </a>

                <div class="flex gap-2 items-center justify-between mt-0.5">
                    <p class="text-[11px] text-gray-400 font-medium">Projeto:
                        <span class="text-gray-500">{{ $project->name ?? $project ?? '' }}</span>
                    </p>
                </div>
            </div>

            {{-- Ações Rápidas (Isoladas do link mestre) --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                <div class="flex gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-100">
                    <a href="{{ route('workflow.edit', $id) }}">
                        <button title="Editar Estrutura"
                            class="btn-editar p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                        </button>
                    </a>
                    <button title="Excluir Workflow"
                        class="btn-excluir p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-red-600 transition-all">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- O clique na descrição também joga o usuário para dentro do Workflow --}}
        <a href="{{ route('workflow.show', $id) }}" class="block mb-4">
            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed hover:text-zinc-700 transition-colors">
                {{ $description ?? 'Sem descrição definida para este workflow.' }}
            </p>
            
            <p class="text-[10px] text-gray-400 font-medium mt-1">
                Criado em: {{ \Carbon\Carbon::parse($createdAt)->format('d/m/Y') }}
            </p>
        </a>

        {{-- Lista de sub-actions internas (Mantidas com seus links próprios individuais) --}}
        <div class="mb-4">
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block">
                Actions
            </span>
            @if(count($actions) > 0)
                <div class="flex flex-wrap gap-2">
                @foreach($actions as $action)
                    @php
                        $editRoute = $action->type === 'api' 
                            ? route('workflow_action.edit', $action->id) 
                            : url("/email/{$action->email_id}/edit"); 
                    @endphp

                    <a href="{{ $editRoute }}" 
                        class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-50 border border-gray-200 text-gray-600 text-[10px] font-semibold rounded-md uppercase hover:bg-gray-200 hover:border-gray-300 transition-colors cursor-pointer" 
                        title="Editar Action ID: {{ $action->id }}">
                        
                        @if($action->type === 'api')
                            <i data-lucide="webhook" class="w-3 h-3 text-cyan-500"></i> API
                        @elseif($action->type === 'email')
                            <i data-lucide="mail" class="w-3 h-3 text-amber-500"></i> EMAIL
                        @else
                            <i data-lucide="zap" class="w-3 h-3 text-gray-400"></i> {{ $action->type }}
                        @endif
                    </a>
                @endforeach
                </div>
            @else
                <p class="text-[11px] text-gray-400 italic">Nenhuma action configurada.</p>
            @endif
        </div>
    </div>

    {{-- Rodapé do Card: Gatilho e Status --}}
    <div>
        <a href="{{ route('workflow.show', $id) }}" class="block">
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 hover:bg-zinc-100/50 transition-colors">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">
                        Trigger Event
                    </span>
                    <div class="flex justify-between items-center">
                        <code class="text-xs text-gray-600 font-mono truncate pr-6">
                            {{ $triggerEvent }}
                        </code>

                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase flex-shrink-0 {{ $status === 'active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                            {{ $status }}
                        </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>