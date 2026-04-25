$(function () {
    // Seletores jQuery
    const $typeInput = $("#type");
    const $emailSection = $("#section-email");
    const $apiSection = $("#section-api");
    const $typeButtons = $(".action-type-btn");

    // Alternar tipo de action
    function switchType(type) {
        $typeInput.val(type);

        // Atualiza o estado visual dos botões
        $typeButtons.each(function () {
            const $btn = $(this);
            $btn.attr("data-active", ($btn.data("type") === type).toString());
        });

        const duration = 300;

        if (type === "email") {
            // Esconde a API e mostra o Email
            $apiSection.fadeOut(duration, function () {
                $emailSection.fadeIn(duration);
            });
        } else {
            // Esconde o Email e mostra a API
            $emailSection.fadeOut(duration, function () {
                $apiSection.fadeIn(duration);
            });
        }
    }

    // Evento de clique nos botões de tipo
    $typeButtons.on("click", function () {
        switchType($(this).data("type"));
    });

    // Restaurar estado após erro de validação
    const initialValue = $typeInput.val();
    switchType(initialValue || "email");

    // ==================== Mapeamentos Dinâmicos ====================

    function createMappingRow(
        $container,
        keyName = "",
        valueName = "",
        placeholder = "",
        classPersonalizada = "", // Classe que define se terá máscara ou estilo especial
    ) {
        // O botão de remover agora é padrão para todos
        const removeBtnHtml = `
        <button type="button" class="remove-row text-red-400 hover:text-red-600 p-2 transition-colors shrink-0">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
        </button>`;

        const rowHtml = `
    <div class="flex items-center gap-3 bg-zinc-50 p-3 rounded-xl border border-zinc-200 mb-2 w-full" style="display: none;">
        
        <div class="flex-1">
            <input type="text" name="${keyName}" 
                   class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none bg-white"
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

        
        $row.find(".value-input").on("blur", function () {
            let $el = $(this);

            // Verifica se o input atual tem a classe que dispara a limpeza/máscara
            if (classPersonalizada && $el.hasClass(classPersonalizada)) {
                let value = $el.val().trim();

                if (value.length > 0) {
                    let cleanValue = value.replace(/[\{\}]/g, "").trim();

                    cleanValue = cleanValue
                        .replace(/\s+/g, "_")
                        .replace(/[^\w]/g, "")
                        .toLowerCase();

                    let finalValue = `{{ ${cleanValue} }}`;
                    $el.val(finalValue);
                }
            }
        });

        // Evento de remoção (sempre ativo)
        $row.find(".remove-row").on("click", function () {
            $row.fadeOut(300, function () {
                $(this).remove();
            });
        });

        // Adiciona ao container e executa o Fade In
        $container.append($row);
        $row.fadeIn(300);

        if (window.lucide) {
            lucide.createIcons();
        }
    }

   

    // Headers
    const $headersContainer = $("#headers-container");
    $("#add-header").on("click", () => {
        createMappingRow(
            $headersContainer,
            "headers_keys[]",
            "headers_values[]",
            "Valor da variável fixa",
        );
    });

    // Body Fields
    const $bodyContainer = $("#body-mappings");
    $("#add-body-field").on("click", () => {
        createMappingRow($bodyContainer, "keys[]", "values[]", "{{variavel}}", "mask-variable");
    });

    // $("#workflow_id").select2({
    //     placeholder: "Selecione um projeto",
    //     width: "100%",
    // });
});
