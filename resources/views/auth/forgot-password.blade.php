<x-layouts.auth>
    <div class="h-[calc(100vh-80px)] flex justify-center items-center">
        <div class="w-[30%] border-2 p-8 flex flex-col justify-center bg-white shadow-xl rounded-lg">
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2 text-gray-800 text-center">Esqueceu a senha?</h2>
                <p class="text-sm text-gray-600 text-center leading-relaxed">
                    {{ __('Sem problemas. Informe seu endereço de e-mail e enviaremos um link para você redefinir sua senha.') }}
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm animate-pulse">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">

                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 bg-cyan-500 text-white font-bold rounded-md shadow-lg shadow-cyan-500/30 hover:bg-cyan-600 hover:scale-[1.02] active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-300 ease-in-out">
                        {{ __('Enviar link de redefinição') }}
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}"
                            class="text-sm text-gray-500 hover:text-cyan-500 underline duration-300">
                            Voltar para o Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>