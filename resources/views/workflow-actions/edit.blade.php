<x-layouts.sistema>

    @push('style')
        @vite('resources/css/pages/select2.css')
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
                    <button
                        class="group flex items-center gap-2 px-4 py-2 bg-white border border-zinc-200 text-zinc-700 text-sm font-medium rounded-lg shadow-sm hover:border-zinc-400 hover:text-zinc-900 hover:shadow-md transition-all duration-200 active:scale-95 focus:ring-2 focus:ring-zinc-100 outline-none">
                        <i data-lucide="arrow-left"
                            class="w-4 h-4 text-zinc-500 group-hover:-translate-x-1 transition-transform duration-200">
                        </i>
                        <span>Voltar</span>
                    </button>
                </a>
            </x-slot:actions>
        </x-sistema.page-presentation>

        <div class="bg-white border border-zinc-200 rounded-2xl shadow-sm overflow-hidden">
            <form action="{{ route('workflow_action.update', $action->id) }}" method="POST" id="form-action"
                class="p-8 space-y-10">
                @csrf

                @method('PUT')


                <div class="flex flex-col gap-2">
                    <label for="workflow_id" class="text-sm font-semibold text-zinc-700">Workflow <span
                            class="text-red-500">*</span></label>

                    <select id="workflow_id" name="workflow_id"
                        class="w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all"
                        required>
                        <option value="">
                            Selecione um projeto
                        </option>

                        @foreach($workflows as $workflow)
                            <option value="{{ $workflow->id }}" {{ $action->workflow_id == $workflow->id ? 'selected' : '' }}>
                                {{ $workflow->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <!-- Tipo da Action -->
                <div>
                    <label class="text-sm font-semibold text-zinc-700 block mb-3">Tipo da Action <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button type="button" id="type-email"
                            class="action-type-btn flex flex-col items-center justify-center gap-3 p-8 border-2 rounded-2xl transition-all hover:border-cyan-500 data-[active=true]:border-cyan-500 data-[active=true]:bg-cyan-50"
                            data-type="email">
                            <div
                                class="w-12 h-12 flex items-center justify-center bg-cyan-100 text-cyan-600 rounded-xl">
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
                            <div
                                class="w-12 h-12 flex items-center justify-center bg-amber-100 text-amber-600 rounded-xl">
                                <i data-lucide="globe" class="w-7 h-7"></i>
                            </div>
                            <div class="text-center">
                                <span class="font-semibold text-zinc-800 block">Chamada de API</span>
                                <span class="text-xs text-zinc-500">Integração externa</span>
                            </div>
                        </button>
                    </div>
                    <input type="hidden" id="type" name="type" value="{{ $action->type ?? '' }}">
                </div>

                <!-- ==================== SEÇÃO EMAIL ==================== -->
                <div id="section-email" class="flex flex-col gap-2">
                    <label for="email_id" class="text-sm font-semibold text-zinc-700">Template de E-mail
                        <span class="text-red-500">*</span></label>

                    <select id="email_id" name="email_id"
                        class="w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition-all">
                        <option value="">Selecione um template...</option>

                        @foreach ($emails as $email)
                            <option value="{{ $email->id }}" {{ $action->email_id == $email->id ? 'selected' : '' }}>
                                {{ $email->subject }}
                            </option>
                        @endforeach

                    </select>


                    <div id="preview-payload-container" class="hidden mt-4 animate-fadeIn">
                        <label class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Exemplo de Requisição
                            para envio do e-mail</label>
                        <p class="mt-2 text-xs text-zinc-500 italic">
                            * Os dados abaixo são exemplificativos e demonstram como as variáveis deste template devem
                            ser estruturadas. Para que o disparo ocorra, você deve enviar os dados completo para o
                            endpoint /event, incluindo sua API KEY e o Trigger do workflow, além dos campos listados.
                        </p>
                        <div class="mt-2 bg-zinc-950 border border-zinc-800 rounded-xl p-4 overflow-hidden relative">
                            <div
                                class="absolute top-3 right-3 text-[10px] bg-cyan-500/10 text-cyan-500 px-2 py-1 rounded-md border border-cyan-500/20">
                                JSON
                            </div>

                            <pre
                                class="text-cyan-400 font-mono text-sm leading-relaxed overflow-x-auto"><code id="json-display"></code></pre>
                        </div>
                        <p class="mt-2 text-xs text-zinc-500 italic">
                            * As variáveis no objeto "payload" foram extraídas automaticamente do seu template.
                        </p>
                    </div>

                </div>





                <!-- ==================== SEÇÃO API ==================== -->

                <div id="section-api" class="action-section space-y-8 hidden">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-zinc-700">URL <span class="text-red-500">*</span></label>
                            <input type="text" name="url" value="{{ old('url', $action->config_api['url'] ?? '') }}"
                                class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none"
                                placeholder="https://api.exemplo.com/endpoint">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-zinc-700">Método HTTP <span class="text-red-500">*</span></label>
                            <select name="method" class="mt-2 w-full px-4 py-3 border border-zinc-300 rounded-xl focus:border-cyan-500 outline-none">
                                <option value="POST" {{ old('method', $action->config_api['method'] ?? '') == 'POST' ? 'selected' : '' }}>POST</option>
                                <option value="PUT" {{ old('method', $action->config_api['method'] ?? '') == 'PUT' ? 'selected' : '' }}>PUT</option>
                                <option value="PATCH" {{ old('method', $action->config_api['method'] ?? '') == 'PATCH' ? 'selected' : '' }}>PATCH</option>
                                <option value="GET" {{ old('method', $action->config_api['method'] ?? '') == 'GET' ? 'selected' : '' }}>GET</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-sm font-semibold text-zinc-700">Headers Estáticos</label>
                            <button type="button" id="add-header" class="flex items-center gap-2 text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i> Adicionar header
                            </button>
                        </div>
                        <div id="headers-container" class="space-y-3"></div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="w-[80%] text-sm font-semibold text-zinc-700">Mapeamento do Body</label>
                            <button type="button" id="add-body-field" class="flex items-center gap-2 text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i> Adicionar campo
                            </button>
                        </div>
                        <div id="body-mappings" class="space-y-3"></div>
                    </div>

                    <div id="preview-payload-api-container" class="mt-6">
                        <label class="text-xs font-bold text-zinc-500 uppercase tracking-wider">Estrutura do Payload esperado no /event</label>
                        <p class="mt-2 text-xs text-zinc-500 italic">
                            * Monte o mapeamento acima para ver como os dados dinâmicos deverão ser enviados na requisição raiz do seu sistema.
                        </p>
                        <div class="mt-2 bg-zinc-950 border border-zinc-800 rounded-xl p-4 overflow-hidden relative">
                            <div class="absolute top-3 right-3 text-[10px] bg-amber-500/10 text-amber-500 px-2 py-1 rounded-md border border-amber-500/20">
                                JSON ESPERADO
                            </div>
                            <pre class="text-amber-400 font-mono text-sm leading-relaxed overflow-x-auto"><code id="json-api-display">{}</code></pre>
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
                        Salvar Action
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        @vite('resources/js/pages/workflow_action.js')

        <script type="module">
    $(document).ready(function () {
        // --- LÓGICA DO EMAIL ---
        const emailTemplates = @json($emails->keyBy('id'));

        $('#email_id').on('change', function () {
            const templateId = $(this).val();
            const $container = $('#preview-payload-container');
            const $display = $('#json-display');

            if (!templateId) {
                $container.addClass('hidden');
                return;
            }

            const body = emailTemplates[templateId].body;
            const regex = /\{\{\s*([\w_]+)\s*\}\}/g;
            let match;
            const variables = {};

            while ((match = regex.exec(body)) !== null) {
                const varName = match[1];
                variables[varName] = "valor_exemplo";
            }

            const jsonExample = {
                recipient: "cliente@email.com",
                payload: variables
            };

            $display.text(JSON.stringify(jsonExample, null, 4));
            $container.removeClass('hidden');
        });

        $('#email_id').trigger('change');


        // --- LÓGICA DO PREVIEW DA API (VERSÃO ROBUSTA) ---
        function atualizarPreviewApi() {
            let payloadExemplo = {};

            // Buscamos todas as linhas/divs de input diretas dentro de body-mappings
            // Independentemente do 'name', pegamos o primeiro input como Chave e o segundo como Valor
            $('#body-mappings > div, #body-mappings .flex').each(function () {
                const $inputs = $(this).find('input[type="text"]');
                
                if ($inputs.length >= 2) {
                    const chave = $inputs.eq(0).val().trim();
                    let valor = $inputs.eq(1).val().trim();

                    if (chave) {
                        // Se o usuário digitou uma variável tipo nome_cliente limpamos os bigodes
                        if (valor.includes('{{')) {
                            valor = valor.replace(/\{\{\s*([\w_]+)\s*\}\}/g, '$1');
                        }
                        payloadExemplo[chave] = valor || "valor_exemplo";
                    }
                }
            });

      

            const estruturaFinal = {
                payload: payloadExemplo
            };

            $('#json-api-display').text(JSON.stringify(estruturaFinal, null, 4));
        }

        // Escuta alterações em QUALQUER input de texto dentro do contêiner do mapeamento do body
        $('#body-mappings').on('input', 'input', function () {
            atualizarPreviewApi();
        });

        // Escuta também quando o usuário clicar em adicionar ou remover campos
        $(document).on('click', '#add-body-field, [id^="add-"], button', function () {
            // Pequeno delay para esperar o DOM injetar ou remover o HTML da tela
            setTimeout(atualizarPreviewApi, 150);
        });

        // Executa assim que a página termina de carregar para atualizar se já houver dados salvos
        setTimeout(atualizarPreviewApi, 300);
    });
</script>


        <script>
            window.existingActionData = {
                headers: @json($action->config_api['headers'] ?? []),
                body: @json($action->config_api['body'] ?? [])
            };
        </script>
    @endpush

</x-layouts.sistema>