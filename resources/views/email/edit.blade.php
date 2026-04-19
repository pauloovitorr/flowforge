<x-layouts.sistema>

    @push('style')
        <!-- Quill CSS -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

        <style>
            .ql-toolbar.ql-snow {
                border-radius: 8px;
            }
        </style>
    @endpush

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops! Verifique os dados',
                    html: `
                                        <ul style="text-align: center;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    `,
                    confirmButtonColor: '#18181b',
                });
            });
        </script>
    @endif

    <div class="w-full grid grid-cols-1">
        <x-sistema.page-presentation icon="mail" page="Novo Template de Email">

            <x-slot:actions>
                <a href="{{ route('email.index') }}">
                    <button id="btn-back-template"
                        class="group flex items-center gap-2 px-4 py-2 bg-white border border-zinc-200 text-zinc-700 text-sm font-medium rounded-lg shadow-sm hover:border-zinc-400 hover:text-zinc-900 hover:shadow-md transition-all duration-200 active:scale-95 focus:ring-2 focus:ring-zinc-100 outline-none">

                        <i data-lucide="arrow-left"
                            class="w-4 h-4 text-zinc-500 group-hover:-translate-x-1 transition-transform duration-200">
                        </i>
                        <span>Voltar</span>
                    </button>
                </a>
            </x-slot:actions>

        </x-sistema.page-presentation>

        <div class="bg-blue-50  p-3 mb-5 rounded-lg text-sm text-blue-800">

            <p class="mb-2"><strong>Personalização:</strong> Use chaves duplas para adicionar campos dinâmicos nos
                inputs de Body e
                destinatário do email.</p>

            <code class="bg-white px-1 py-0.5 rounded border border-blue-200 text-blue-900">
                            @{{ nome_do_cliente }}</code>
            <span class="ml-1">será substituído pelo valor enviado no endpoint com a chave
                nome_do_cliente.</span>

            <p class="mt-2">Efetue o cadastro com <strong>ATENÇÃO!</strong></p>
        </div>


        <div class="bg-white border border-zinc-200 rounded-xl shadow-sm">
            <form action="{{ route('email.update', $email->id) }}" method="post" id="form-email-template"
                class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Campo Assunto  --}}
                    <div class="flex flex-col gap-1">
                        <label for="subject" class="text-sm font-medium text-zinc-700">Assunto do E-mail <span
                                class="text-red-600">*</span></label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject', $email->subject) }}"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            placeholder="Ex: Bem-vindo à nossa plataforma!" required>
                    </div>

                    {{-- Campo Status --}}
                    <div class="flex flex-col gap-1">
                        <label for="template-status" class="text-sm font-medium text-zinc-700">Status do Template <span
                                class="text-red-600">*</span></label>
                        <select id="template-status" name="status"
                            class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                            required>
                            <option value="active" {{ old('status', $email->status) == 'active' ? 'selected' : '' }}>Ativo
                            </option>
                            <option value="inactive" {{ old('status', $email->status) == 'inactive' ? 'selected' : '' }}>
                                Inativo</option>
                        </select>
                    </div>
                </div>

                {{-- Novo Campo: Variável do Destinatário --}}
                <div class="flex flex-col gap-1">
                    <label for="recipient" class="text-sm font-medium text-zinc-700">
                        Variável do destinatário do E-mail <span class="text-red-600">* (Campo espera o nome da
                            variável)</span>
                    </label>
                    <input type="text" id="recipient" name="recipient" value="{{ old('recipient', $email->recipient) }}"
                        class="w-full p-2.5 border border-zinc-300 rounded-lg outline-none focus:border-cyan-500 transition-all"
                        placeholder="Ex: @{{ email_cliente }}" required>
                </div>

                {{-- Campo Body - Quill Editor --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-zinc-700">Conteúdo do Email (Body) <span
                            class="text-red-600">* (Campo aceita variável utilizando o formato de máscara informado
                            acima)</span></label>

                   

                    <input type="hidden" name="body" id="template-body" value="{{ old('body', $email->body) }}" required>
                    <div id="quill-editor" class="bg-white border border-zinc-300 rounded-lg min-h-[300px]">
                        {!! old('body', $email->body) !!}
                    </div>
                </div>

                <div class="pt-6 flex justify-end items-center gap-4">
                    <a href="{{ route('email.index') }}">
                        <button type="button" class="text-sm font-medium text-zinc-600 hover:text-zinc-900">
                            Cancelar
                        </button>
                    </a>
                    <button type="submit" id="btn-save-template"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-zinc-900 rounded-lg hover:bg-black transition-all shadow-sm">
                        Atualizar Template
                    </button>
                </div>
            </form>
        </div>


    </div>

    @push('script')
        <!-- Quill JS -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

        @vite('resources/js/pages/email-create.js')
    @endpush

</x-layouts.sistema>