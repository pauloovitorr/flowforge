@props(['icon', 'page'])

<div class="h-16  flex items-center mb-8 border-b-[1px]">
    <div class="bg-gray-100 rounded-md p-2 mr-2">
        <i data-lucide="{{ $icon }}" class="text-xs text-zinc-700"></i>
    </div>
    <h1 class="text-2xl text-zinc-900">{{ $page }}</h1>
</div>