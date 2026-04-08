<x-layouts.sistema>

    @push('style')
        @vite('resources/css/pages/workflow.css')
    @endpush

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops! Verifique os dados',
                    html: `
                        <ul class="text-left list-disc pl-5">
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

    <div class="w-full max-w-5xl mx-auto">
        <x-sistema.page-presentation icon="bolt" page="Nova Action">
            <x-slot:actions>
                <a href="{{ route('workflow_action.index') }}">
                    <button class="group flex items-center gap-2 px-4 py-2 bg-white border border-zinc-200 text-zinc-700 text-sm font-medium rounded-xl shadow-sm hover:border-zinc-400 hover:text-zinc-900 hover:shadow transition-all active:scale-95">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Voltar</span>
                    </button>
                </a>
            </x-slot:actions>
        </x-sistema.page-presentation>

        <div class="bg-white border border-zinc-200 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('workflow_action.store') }}" method="POST" id="form-action" class="p-8 space-y-10">
                @csrf

                <!-- Nome da Action -->
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-semibold text-zinc-700">Nome da Action <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all"
                           placeholder="Ex: Enviar e-mail de boas-vindas" required>
                </div>

                <!-- Tipo da Action -->
                <div>
                    <label class="text-sm font-semibold text-zinc-700 block mb-3">Tipo da Action <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button type="button" id="type-email"
                                class="action-type-btn flex flex-col items-center justify-center gap-3 p-8 border-2 rounded-2xl transition-all hover:border-cyan-500 data-[active=true]:border-cyan-500 data-[active=true]:bg-cyan-50"
                                data-type="email">
                            <div class="w-12 h-12 flex items-center justify-center bg-cyan-100 text-cyan-600 rounded-xl">
                                <i data-lucide="mail" class="w-7 h-7"></i>
                            </div>
                            <div class="text-center">
                                <span class="font-semibold text-zinc-800 block">Enviar E-mail</span>
                                <span class="text-xs text-zinc-500">Utiliza template salvo</span>
                            </div>
                        </button>

                        <button type="button" id="type-api"
                                class="action-type-btn flex flex-col items-center justify-center gap-3 p-8 border-2 rounded-2xl transition-all hover:border-cyan-500 data-[active=true]:border-cyan-500 data-[active=true]:bg-cyan-50"
                                data-type="api">
                            <div class="w-12 h-12 flex items-center justify-center bg-amber-100 text-amber-600 rounded-xl">
                                <i data-lucide="globe" class="w-7 h-7"></i>
                            </div>
                            <div class="text-center">
                                <span class="font-semibold text-zinc-800 block">Chamada de API</span>
                                <span class="text-xs text-zinc-500">Integração externa</span>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" id="type" name="type" value="{{ old('type', 'email') }}" required>
                </div>

                <!-- ==================== SEÇÃO EMAIL ==================== -->
                <div id="section-email" class="action-section space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="template_id" class="text-sm font-semibold text-zinc-700">Template de E-mail <span class="text-red-500">*</span></label>
                            <select id="template_id" name="template_id" 
                                    class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none">
                                <option value="">Selecione um template...</option>
                                <!-- Preencher via JS ou com  no backend -->
                            </select>
                        </div>

                        <div>
                            <label for="subject" class="text-sm font-semibold text-zinc-700">Assunto do E-mail</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                   class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none"
                                   placeholder="Ex: Bem-vindo à nossa plataforma!">
                        </div>
                    </div>

                    <!-- Mapeamento de Variáveis -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <label class="text-sm font-semibold text-zinc-700">Mapeamento de Variáveis</label>
                                <p class="text-xs text-zinc-500 mt-1">Relacione as variáveis do template com campos do payload do evento</p>
                            </div>
                            <button type="button" id="add-mapping-email"
                                    class="flex items-center gap-2 text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                                Adicionar mapeamento
                            </button>
                        </div>

                        <div id="email-mappings" class="space-y-3">
                            <!-- Preenchido via JS -->
                        </div>
                    </div>
                </div>

                <!-- ==================== SEÇÃO API ==================== -->
                <div id="section-api" class="action-section space-y-8 hidden">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-zinc-700">URL <span class="text-red-500">*</span></label>
                            <input type="url" name="url" value="{{ old('url') }}"
                                   class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none"
                                   placeholder="https://api.exemplo.com/endpoint" required>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-zinc-700">Método HTTP <span class="text-red-500">*</span></label>
                            <select name="method" class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none" required>
                                <option value="POST" {{ old('method') == 'POST' ? 'selected' : '' }}>POST</option>
                                <option value="PUT" {{ old('method') == 'PUT' ? 'selected' : '' }}>PUT</option>
                                <option value="PATCH" {{ old('method') == 'PATCH' ? 'selected' : '' }}>PATCH</option>
                                <option value="GET" {{ old('method') == 'GET' ? 'selected' : '' }}>GET</option>
                            </select>
                        </div>
                    </div>

                    <!-- Headers -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-semibold text-zinc-700">Headers</label>
                            <button type="button" id="add-header" class="flex items-center gap-2 text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                                Adicionar header
                            </button>
                        </div>
                        <div id="headers-container" class="space-y-3"></div>
                    </div>

                    <!-- Body -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-semibold text-zinc-700">Body da Requisição</label>
                            <button type="button" id="add-body-field" class="flex items-center gap-2 text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                                Adicionar campo
                            </button>
                        </div>
                        <div id="body-mappings" class="space-y-3"></div>
                    </div>

                    <!-- Autenticação -->
                    <div>
                        <label class="text-sm font-semibold text-zinc-700">Autenticação</label>
                        <select id="auth_type" name="auth_type" 
                                class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none">
                            <option value="none">Sem autenticação</option>
                            <option value="bearer">Bearer Token</option>
                            <option value="basic">Basic Auth</option>
                            <option value="api_key">API Key</option>
                            <option value="dynamic">Dinâmico (do payload)</option>
                        </select>

                        <div id="auth-config-section" class="mt-6 hidden">
                            <label class="text-sm font-semibold text-zinc-700 block mb-3">Configuração de Autenticação</label>
                            <div id="auth-mappings" class="space-y-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="pt-8 border-t border-zinc-100 flex justify-end gap-4">
                    <a href="{{ route('workflow_action.index') }}" 
                       class="px-6 py-3 text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" id="btn-save-action"
                            class="px-8 py-3 bg-zinc-900 hover:bg-black text-white font-semibold rounded-2xl flex items-center gap-2 transition-all active:scale-95">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Salvar Action
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        @vite('resources/js/pages/action.js')

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const typeInput = document.getElementById('type');
                const emailSection = document.getElementById('section-email');
                const apiSection = document.getElementById('section-api');
                const typeButtons = document.querySelectorAll('.action-type-btn');

                // Alternar tipo de action
                function switchType(type) {
                    typeInput.value = type;

                    typeButtons.forEach(btn => {
                        btn.dataset.active = (btn.dataset.type === type).toString();
                    });

                    emailSection.classList.toggle('hidden', type !== 'email');
                    apiSection.classList.toggle('hidden', type !== 'api');
                }

                typeButtons.forEach(btn => {
                    btn.addEventListener('click', () => switchType(btn.dataset.type));
                });

                // Restaurar estado após erro de validação
                if (typeInput.value) {
                    switchType(typeInput.value);
                } else {
                    switchType('email');
                }

                // ==================== Mapeamentos Dinâmicos ====================

                function createMappingRow(container, keyName = '', valueName = '', isRemovable = true) {
                    const row = document.createElement('div');
                    row.className = 'grid grid-cols-12 gap-3 items-center bg-zinc-50 p-4 rounded-xl border border-zinc-100';

                    row.innerHTML = `
                        <div class="col-span-5">
                            <input type="text" name="${keyName}[]" 
                                   class="w-full px-4 py-2.5 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none"
                                   placeholder="Nome da variável / chave" value="">
                        </div>
                        <div class="col-span-1 flex justify-center text-zinc-400">
                            →
                        </div>
                        <div class="col-span-5">
                            <input type="text" name="${valueName}[]" 
                                   class="w-full px-4 py-2.5 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none"
                                   placeholder="payload.cliente.nome" value="">
                        </div>
                        ${isRemovable ? `
                        <div class="col-span-1">
                            <button type="button" class="remove-row text-red-500 hover:text-red-700 p-2">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>` : ''}
                    `;

                    // Evento de remover
                    if (isRemovable) {
                        row.querySelector('.remove-row').addEventListener('click', () => row.remove());
                    }

                    container.appendChild(row);
                    return row;
                }

                // Email Mappings
                const emailMappingsContainer = document.getElementById('email-mappings');
                document.getElementById('add-mapping-email').addEventListener('click', () => {
                    createMappingRow(emailMappingsContainer, 'template_variables[]', 'payload_paths[]');
                });

                // Headers
                const headersContainer = document.getElementById('headers-container');
                document.getElementById('add-header').addEventListener('click', () => {
                    createMappingRow(headersContainer, 'headers_keys[]', 'headers_values[]');
                });

                // Body Fields
                const bodyContainer = document.getElementById('body-mappings');
                document.getElementById('add-body-field').addEventListener('click', () => {
                    createMappingRow(bodyContainer, 'body_keys[]', 'body_values[]');
                });

                // Auth Mappings (quando auth_type = dynamic)
                const authTypeSelect = document.getElementById('auth_type');
                const authConfigSection = document.getElementById('auth-config-section');
                const authMappingsContainer = document.getElementById('auth-mappings');

                authTypeSelect.addEventListener('change', () => {
                    if (authTypeSelect.value === 'dynamic') {
                        authConfigSection.classList.remove('hidden');
                    } else {
                        authConfigSection.classList.add('hidden');
                        authMappingsContainer.innerHTML = '';
                    }
                });

                // Adicionar mapeamento de auth quando necessário
                // (pode ser expandido conforme sua lógica de auth)

                // Inicializar com pelo menos um campo em cada seção (opcional)
                // createMappingRow(emailMappingsContainer, 'template_variables[]', 'payload_paths[]');
                // createMappingRow(headersContainer, 'headers_keys[]', 'headers_values[]');

            });
        </script>
    @endpush

</x-layouts.sistema>