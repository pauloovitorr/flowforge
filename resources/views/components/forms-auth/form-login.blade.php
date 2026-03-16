<div class="w-[30%] border-2 p-8 flex flex-col justify-center bg-white">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Entrar na conta</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email" id="email" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:cyan-500 focus:cyan-500 transition-all duration-200">

            @error('email')
                <span class="text-red-500 text-sm mt-1"> {{ $message }} </span>
            @enderror

        </div>

        <!-- Senha -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" name="password" id="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:cyan-500 focus:cyan-500 transition-all duration-200">

            @error('password')
                <span class="text-red-500 text-sm mt-1"> {{ $message }} </span>
            @enderror

        </div>

        <!-- Lembrar-me -->
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center text-sm text-gray-600">
                <input type="checkbox" name="remember"
                    class="rounded border-gray-300 text-cyan-500 focus:cyan-500">
                <span class="ml-2">Lembrar de mim</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-cyan-500 hover:text-indigo-500 underline">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <!-- Botão com Transição -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-700 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:cyan-500 transition-all duration-300 ease-in-out">
                Entrar
            </button>
        </div>
    </form>
</div>