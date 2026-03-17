<div class="w-[30%] border-2 p-8 flex flex-col justify-center bg-white">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Criar conta</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nome completo</label>
            <input type="text" name="name" id="name" :value="old('name')" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">
            
            @error('name')
                <span class="text-red-500 text-sm mt-1 block"> {{ $message }} </span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email" id="email" :value="old('email')" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">

            @error('email')
                <span class="text-red-500 text-sm mt-1 block"> {{ $message }} </span>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
            <input type="password" name="password" id="password" required autocomplete="new-password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">

            @error('password')
                <span class="text-red-500 text-sm mt-1 block"> {{ $message }} </span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all duration-200">

            @error('password_confirmation')
                <span class="text-red-500 text-sm mt-1 block"> {{ $message }} </span>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md text-sm font-medium text-white bg-cyan-500 hover:bg-cyan-700 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-cyan-500 transition-all duration-300 ease-in-out">
                Cadastrar
            </button>
        </div>

        <div class="mt-6 flex justify-center">
            <span class="text-center text-sm">
                Já possui conta? 
                <a href="{{ route('login') }}" class="text-cyan-500 hover:text-cyan-700 underline duration-300 ease-in-out">Faça o login!</a>
            </span>
        </div>
    </form>
</div>