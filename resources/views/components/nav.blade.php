<nav class="w-[98%] max-w-7xl mx-auto flex justify-between items-center py-6">
    <div class="logo font-black text-2xl tracking-[0.2em] uppercase text-slate-800">
        Flow<span class="text-cyan-500">Forge</span>
    </div>
    <div>
        <ul class="flex gap-8 items-center">
            <li><a href="#" class="hover:text-cyan-600">Home</a></li>
            <li><a href="#" class="hover:text-cyan-600">Sobre</a></li>
            <li><a href="#" class="hover:text-cyan-600">Serviços</a></li>
            <li><a href="#" class="hover:text-cyan-600">Blog</a></li>
            <li><a href="#" class="hover:text-cyan-600">Contato</a></li>

            {{-- Botão de Login (Estilo Diferente) --}}

            @auth
                <li>
                    <a href="{{ route('login') }}"
                        class=" {{ request()->routeIs('login') ? 'text-cyan-600' : 'bg-slate-800 text-white hover:bg-slate-700' }}">
                        Logout
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}"
                        class=" {{ request()->routeIs('login') ? 'text-cyan-600' : 'bg-slate-800 text-white hover:bg-slate-700' }}">
                        Login
                    </a>
                </li>

            @endauth
        </ul>
    </div>
</nav>