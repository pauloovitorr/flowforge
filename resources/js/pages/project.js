import Swal from "sweetalert2";

$(function () {
 
    $("#btn-add-project").on("click", function () {
        abrirModalProjeto();
    });

    $('.btn-copiar').on("click", function () {
        const apiKey = $(this).closest(".bg-zinc-50").find("code").text();
        navigator.clipboard.writeText(apiKey);

        Swal.fire({
            toast: true,
            position: "bottom-end",
            icon: "success",
            title: "Chave copiada!",
            showConfirmButton: false,
            timer: 2000,
        });
    });
});

function abrirModalProjeto() {
    Swal.fire({
        title: "Novo Projeto",
        html: `
            <div class="text-left">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Projeto</label>
                <input type="text" id="project-name" class="w-full p-2 border border-gray-300 rounded-md outline-none focus:border-zinc-900" placeholder="Ex: Meu App">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: "Criar Projeto",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#18181b",
        preConfirm: () => {
            const name = document.getElementById("project-name").value;
            if (!name) {
                Swal.showValidationMessage("O nome é obrigatório");
                return false;
            }
            return { name: name };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            salvarProjeto(result.value.name);
        }
    });
}

function salvarProjeto(nome) {
    Swal.fire({
        title: "Salvando projeto...",
        text: "Por favor, aguarde.",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    $("#btn-add-project").prop("disabled", true);

    $.ajax({
        url: "/project",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            name: nome,
        },
        success: function (response) {
            Swal.fire({
                title: "Sucesso!",
                text: response.message,
                icon: "success",
                confirmButtonText: "OK",
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });

            $("#btn-add-project").prop("disabled", false);
        },
        error: function () {
            Swal.fire("Erro!", "Falha ao salvar.", "error");

            $("#btn-add-project").prop("disabled", false);
        },
    });
}
