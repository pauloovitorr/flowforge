<x-layouts.sistema>



    <x-sistema.page-presentation icon="mail" page="Lista de Templates de E-mails">

        <x-slot:actions>
            <a href="{{ route('email.create') }}">
                <button
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
      <h1>Desenvolvimento</h1>
    </div>



    @push('script')
        @vite('resources/js/pages/workflow.js')
    @endpush
</x-layouts.sistema>