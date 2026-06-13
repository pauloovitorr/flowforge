<x-layouts.auth>
    <div class="w-[30%] border-2 p-8 flex flex-col justify-center bg-white shadow-xl rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Nova Senha</h2>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ __('Crie uma nova senha segura para sua conta.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required readonly
                    class="mt-1 block w-full px-3 py-2 border border-gray-200 bg-gray-50 rounded-md text-gray-500 cursor-not-allowed outline-none">
                
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                <input type="password" name="password" id="password" required autofocus autocomplete="new-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">
                
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 bg-cyan-500 text-white font-bold rounded-md shadow-lg shadow-cyan-500/30 hover:bg-cyan-600 hover:scale-[1.02] active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-300 ease-in-out">
                    {{ __('Redefinir Senha') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.auth>