<x-layouts.auth>
    <div class="h-[calc(100vh-80px)] flex justify-center items-center">
        <div class="w-[30%] border-2 p-8 flex flex-col justify-center  bg-white shadow-xl rounded-lg">
            <div class="mb-6 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-cyan-100 text-cyan-500 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/api/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Verifique seu e-mail</h2>
            </div>

            <div class="mb-6 text-sm text-gray-600 text-center leading-relaxed">
                {{ __('Quase lá! Enviamos um link de confirmação para o seu e-mail. Por favor, clique nele para ativar sua conta.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm animate-pulse">
                    {{ __('Um novo link foi enviado para o endereço informado.') }}
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-700 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-300 ease-in-out shadow-md">
                        {{ __('Reenviar e-mail de verificação') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="flex justify-center">
                    @csrf
                    <button type="submit"
                        class="text-sm text-gray-500 hover:text-cyan-500 underline transition-colors duration-300">
                        {{ __('Sair e tentar outro e-mail') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.auth>