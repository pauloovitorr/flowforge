<nav class="w-[98%] max-w-7xl mx-auto flex justify-between items-center py-6">
    <a href="{{ route('home') }}">
        <div class="logo font-black text-2xl tracking-[0.2em] uppercase text-slate-800">
            Flow<span class="text-cyan-500">Forge</span>
        </div>
    </a>
    <div>
        <ul class="flex gap-8 items-center">

            <li><a href="#" class="hover:text-cyan-700 duration-300 ease-in-out">Sobre</a></li>
            <li><a href="#" class="hover:text-cyan-700 duration-300 ease-in-out">Serviços</a></li>
            <li><a href="#" class="hover:text-cyan-700 duration-300 ease-in-out">Blog</a></li>
            <li><a href="#" class="hover:text-cyan-700 duration-300 ease-in-out">Contato</a></li>

            
            <li>
                <a href="{{ route('login') }}"
                    class=" {{ request()->routeIs('login') ? 'text-cyan-700' : 'hover:text-cyan-700' }} duration-300 ease-in-out">
                    Login
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}"
                    class=" {{ request()->routeIs('register') ? 'text-cyan-700' : 'hover:text-cyan-700' }} duration-300 ease-in-out">
                    Criar Conta
                </a>
            </li>
        </ul>
    </div>
</nav>