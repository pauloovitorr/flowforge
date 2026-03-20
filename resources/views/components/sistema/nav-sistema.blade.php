<nav class="w-[100%] mb-4 py-6 shadow-sm bg-white">
    <div class="w-[96%] max-w-7xl mx-auto  flex justify-between items-center">
        <!-- Logo -->
    <a href="{{ route('home') }}" class="font-black text-2xl tracking-[0.2em] uppercase text-slate-800  transition-colors">
        Flow<span class="text-cyan-500">Forge</span>
    </a>
    
    <!-- Ações do usuário -->
    <div class="flex items-center gap-4 ml-auto">
        <div class="hidden md:block w-72">
            <div class="relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input 
                    type="text" 
                    placeholder="Pesquisar workflows, projetos..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-100/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200"
                >
            </div>
        </div>
        
        <!-- Botão pesquisa mobile -->
        <button class="md:hidden p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
            <i data-lucide="search" class="w-6 h-6"></i>
        </button>

        <!-- Notificações -->
        <button class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
            <i data-lucide="bell" class="w-6 h-6"></i>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-xs text-white rounded-full flex items-center justify-center">3</span>
        </button>
        
        <!-- Perfil (melhor responsivo) -->
        <div class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-xl transition-all cursor-pointer group md:gap-3">
            <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="hidden md:flex flex-col items-end gap-0.5 mr-1">
                <span class="text-sm font-medium text-gray-900 group-hover:text-cyan-500">
                    {{ auth()->user()->name }}
                </span>
            </div>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 ml-1"></i>
        </div>
    </div>
    </div>
</nav>
