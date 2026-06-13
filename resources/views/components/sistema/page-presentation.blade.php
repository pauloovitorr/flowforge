@props(['icon', 'page'])

<div class="flex items-center justify-between mb-8 pb-5 border-b-[1px] border-zinc-100">
    <div class="flex items-center">
        <div class="bg-gray-100 rounded-md p-2 mr-2">
            <i data-lucide="{{ $icon }}" class="text-xs text-zinc-700"></i>
        </div>
        <h1 class="text-2xl text-zinc-900">{{ $page }}</h1>
    </div>

    {{-- Verifica se o slot 'actions' foi preenchido --}}
    @if (isset($actions))
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>