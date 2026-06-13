@props(['id', 'name', 'createdAt', 'apiKey'])

<div data-id="{{ $id }}" class="project relative p-5 border-[1px] border-zinc-200 rounded-xl bg-white shadow-sm flex flex-col justify-between h-44">
    <div class="flex justify-between items-start">
        <div class="truncate pr-2">
            <h3 class="font-semibold text-zinc-800 truncate" title="{{ $name }}">
                {{ $name }}
            </h3>
            <p class="text-[10px] text-zinc-500 mt-0.5">

                Criado em: {{ $createdAt->format('d/m/Y') }}
            </p>
        </div>

        <div class="flex gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-100">
            <button title="Editar" 
                class="btn-editar p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
            </button>
            <button title="Excluir"
                class="btn-excluir p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-red-600 transition-all">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
            </button>
        </div>
        
    </div>

    <div class="bg-zinc-50 p-2.5 rounded-lg border border-zinc-100 mt-4">
        <div class="flex justify-between items-center mb-1">
            <span class="text-[9px] text-zinc-400 uppercase font-bold tracking-wider">API KEY</span>

            <button title="Copiar" 
                class="btn-copiar p-1.5 hover:bg-white hover:shadow-sm rounded-md text-zinc-600 hover:text-gray-900 transition-all">
                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
            </button>
        </div>
        <code class="text-xs text-zinc-600 truncate block font-mono" title="{{ $apiKey }}">
            {{ $apiKey }}
        </code>
    </div>
</div>