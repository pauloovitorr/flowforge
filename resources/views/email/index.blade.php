<x-layouts.sistema>

    <x-sistema.page-presentation icon="mail" page="Lista de Templates de E-mails">
        <x-slot:actions>
            <a href="{{ route('email.create') }}">
                <button id="btn-add-email"
                    class="flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md transition-all duration-200 shadow-sm active:scale-95">
                    <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    Adicionar
                </button>
            </a>
        </x-slot:actions>
    </x-sistema.page-presentation>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#18181b'
                });
            });
        </script>
    @endif

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($emails as $email)
           <x-sistema.template-email-component.list-email :email="$email"/>        
        @empty
            <div
                class="col-span-full border-2 border-dashed border-gray-200 rounded-xl p-12 flex flex-col items-center justify-center">
                <div class="text-gray-300 mb-3">
                    <i data-lucide="mail" class="w-8 h-8"></i>
                </div>
                <p class="text-gray-500 font-medium">Nenhum template encontrado</p>
                <p class="text-sm text-gray-400">Comece adicionando seu primeiro modelo de e-mail.</p>
            </div>
        @endforelse
    </div>

    @push('script')
        @vite('resources/js/pages/email-index.js')
    @endpush

</x-layouts.sistema>