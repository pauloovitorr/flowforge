$(function () {
    // Seletores jQuery
    const $typeInput = $("#type");
    const $emailSection = $("#section-email");
    const $apiSection = $("#section-api");
    const $typeButtons = $(".action-type-btn");

    // Alternar tipo de action
    function switchType(type) {
        $typeInput.val(type);

        $typeButtons.each(function() {
            const $btn = $(this);
            $btn.attr("data-active", ($btn.data("type") === type).toString());
        });

        $emailSection.toggleClass("hidden", type !== "email");
        $apiSection.toggleClass("hidden", type !== "api");
    }

    // Evento de clique nos botões de tipo
    $typeButtons.on("click", function() {
        switchType($(this).data("type"));
    });

    // Restaurar estado após erro de validação
    const initialValue = $typeInput.val();
    switchType(initialValue || "email");

    // ==================== Mapeamentos Dinâmicos ====================

    function createMappingRow($container, keyName = "", valueName = "", placeholder='', isRemovable = true,) {
        const removeBtnHtml = isRemovable 
            ? `<div class="col-span-1">
                <button type="button" class="remove-row text-red-500 hover:text-red-700 p-2">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
               </div>` 
            : "";

        const rowHtml = `
            <div class="grid grid-cols-12 gap-3 items-center bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="col-span-5">
                    <input type="text" name="${keyName}" 
                           class="w-full px-4 py-2.5 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none"
                           placeholder="Nome da variável / chave" value="">
                </div>
                <div class="col-span-1 flex justify-center text-zinc-400">
                    →
                </div>
                <div class="col-span-5">
                    <input type="text" name="${valueName}" 
                           class="w-full px-4 py-2.5 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none"
                           placeholder="${placeholder}">
                </div>
                ${removeBtnHtml}
            </div>`;

        const $row = $(rowHtml);

        // Evento de remover usando delegação ou evento direto no novo elemento
        if (isRemovable) {
            $row.find(".remove-row").on("click", function() {
                $row.remove();
            });
        }

        $container.append($row);
        
        // Se estiver usando Lucide Icons, precisa disparar o refresh para o novo ícone
        if (window.lucide) {
            lucide.createIcons();
        }

        return $row;
    }

    // Email Mappings
    const $emailMappingsContainer = $("#email-mappings");
    $("#add-mapping-email").on("click", () => {
        createMappingRow($emailMappingsContainer, "template_variables[]", "payload_paths[]", "payload.dado");
    });

    // Headers
    const $headersContainer = $("#headers-container");
    $("#add-header").on("click", () => {
        createMappingRow($headersContainer, "headers_keys[]", "headers_values[]", "Valor da variável fixa");
    });

    // Body Fields
    const $bodyContainer = $("#body-mappings");
    $("#add-body-field").on("click", () => {
        createMappingRow($bodyContainer, "body_keys[]", "body_values[]", "payload.dado");
    });

    // Auth Mappings
    const $authTypeSelect = $("#auth_type");
    const $authConfigSection = $("#auth-config-section");

    $('#token_auth').prop('disabled', true)
    $('#token_auth').css('opacity', '0.3')

    $authTypeSelect.on("change", function() {
        if ($(this).val() === "none") {
            $('#token_auth').prop('disabled', true)
            $('#token_auth').css('opacity', '0.3')

        } else {
            $('#token_auth').prop('disabled', false)
            $('#token_auth').css('opacity', '1')
        }
    });

});