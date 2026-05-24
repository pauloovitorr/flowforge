$(function () {
    // ==================== 1. SELETORES JQUERY ====================
    const $typeInput = $("#type");
    const $emailSection = $("#section-email");
    const $apiSection = $("#section-api");
    const $typeButtons = $(".action-type-btn");
    const $headersContainer = $("#headers-container");
    const $bodyContainer = $("#body-mappings");

    // ==================== 2. LÓGICA DE TROCA DE TIPO ====================
    function switchType(type) {
        $typeInput.val(type);

        $typeButtons.each(function () {
            const $btn = $(this);
            $btn.attr("data-active", ($btn.data("type") === type).toString());
        });

        const duration = 300;

        if (type === "email") {
            $apiSection.fadeOut(duration, function () {
                $emailSection.fadeIn(duration);
            });
        } else {
            $emailSection.fadeOut(duration, function () {
                $apiSection.fadeIn(duration);
            });
        }
    }

    $typeButtons.on("click", function () {
        switchType($(this).data("type"));
    });

    const initialValue = $typeInput.val();
    switchType(initialValue || "email");

    // ==================== 3. CRIAÇÃO DE CAMPOS DINÂMICOS ====================
    function createMappingRow(
        $container,
        keyName = "",
        valueName = "",
        placeholder = "",
        classPersonalizada = "",
        initialKey = "",
        initialValue = "",
        isLoad = false // NOVO: Controla se é carregamento inicial
    ) {
        const removeBtnHtml = `
        <button type="button" class="remove-row text-red-400 hover:text-red-600 p-2 transition-colors shrink-0">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
        </button>`;

        // Se for load inicial (edição), não usa display: none. Já entra visível mantendo o layout flex
        const displayStyle = isLoad ? "" : 'style="display: none;"';

        const rowHtml = `
        <div class="flex items-center gap-3 bg-zinc-50 p-3 rounded-xl border border-zinc-200 mb-2 w-full" ${displayStyle}>
            <div class="flex-1">
                <input type="text" name="${keyName}" 
                       class="key-input w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none bg-white"
                       placeholder="Chave">
            </div>
            <div class="shrink-0 flex items-center justify-center text-zinc-400">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
            <div class="flex-1">
                <input type="text" name="${valueName}" 
                       class="value-input w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none bg-white ${classPersonalizada}"
                       placeholder="${placeholder}">
            </div>
            <div class="shrink-0">
                ${removeBtnHtml}
            </div>
        </div>`;

        const $row = $(rowHtml);

        // Preenche valores na edição
        if (initialKey) $row.find(".key-input").val(initialKey);
        if (initialValue) $row.find(".value-input").val(initialValue);

        // Evento de Blur para máscara
        $row.find(".value-input").on("blur", function () {
            let $el = $(this);
            if (classPersonalizada && $el.hasClass(classPersonalizada)) {
                let value = $el.val().trim();
                if (value.length > 0) {
                    let cleanValue = value.replace(/[\{\}]/g, "").trim();
                    cleanValue = cleanValue.replace(/\s+/g, "_").replace(/[^\w]/g, "").toLowerCase();
                    let finalValue = `{{ ${cleanValue} }}`;
                    $el.val(finalValue);
                }
            }
        });

        // Evento de remover
        $row.find(".remove-row").on("click", function () {
            $row.fadeOut(300, function () {
                $(this).remove();
            });
        });

        $container.append($row);
        
        // Se foi clicado pelo botão (novo campo), faz o fadeIn. Se for Load, já entra na tela normal.
        if (!isLoad) {
            $row.fadeIn(300);
        }

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    // ==================== 4. BOTÕES DE ADICIONAR ====================
    $("#add-header").on("click", () => {
        createMappingRow($headersContainer, "headers_keys[]", "headers_values[]", "Valor da variável fixa");
    });

    $("#add-body-field").on("click", () => {
        createMappingRow($bodyContainer, "body_keys[]", "body_values[]", "{{variavel}}", "mask-variable");
    });

    // ==================== 5. CARREGAR DADOS EXISTENTES (EDIÇÃO) ====================
    if (window.existingActionData) {
      

        const headers = window.existingActionData.headers;
        const body = window.existingActionData.body;

        // Monta os inputs de Headers verificando se não estão vazios
        if (headers && Object.keys(headers).length > 0) {
            Object.entries(headers).forEach(([key, value]) => {
                // O último parâmetro 'true' diz que é um carregamento inicial
                createMappingRow($headersContainer, "headers_keys[]", "headers_values[]", "Valor da variável fixa", "", key, value, true);
            });
        }

        // Monta os inputs do Body verificando se não estão vazios
        if (body && Object.keys(body).length > 0) {
            Object.entries(body).forEach(([key, value]) => {
                // O último parâmetro 'true' diz que é um carregamento inicial
                createMappingRow($bodyContainer, "body_keys[]", "body_values[]", "{{variavel}}", "mask-variable", key, value, true);
            });
        }
    }
});