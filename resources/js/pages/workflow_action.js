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

function createMappingRow($container, keyName = "", valueName = "", placeholder='', isRemovable = true) {
    const removeBtnHtml = isRemovable 
        ? `<button type="button" class="remove-row text-red-400 hover:text-red-600 p-2 transition-colors shrink-0">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
           </button>` 
        : `<div class="w-9"></div>`;

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
                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg text-sm focus:border-cyan-500 outline-none bg-white"
                       placeholder="${placeholder}">
            </div>
            
            <div class="shrink-0">
                ${removeBtnHtml}
            </div>
        </div>`;

    const $row = $(rowHtml);

    // Lógica de Fade Out com Remoção Real
    if (isRemovable) {
        $row.find(".remove-row").on("click", function() {
            $row.fadeOut(300, function() {
                $(this).remove(); // Remove do DOM após sumir
            });
        });
    }

    // Adiciona ao container e executa o Fade In
    $container.append($row);
    $row.fadeIn(300); 
    
    if (window.lucide) {
        lucide.createIcons();
    }
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