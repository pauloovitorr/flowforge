import Swal from "sweetalert2";

$(function () {
    $("#btn-add-project").on("click", function () {
        abrirModalProjeto();
    });

    $(".btn-editar").on("click", function () {
        let $card = $(this).closest(".project");
        let id_project = $card.data("id");
        let nome = $card.find('h3').text().trim()
        
        editarProjeto(id_project,nome)

    });

    $(".btn-excluir").on("click", function () {
        let $card = $(this).closest(".project");
        let id_project = $card.data("id");

        Swal.fire({
            title: "Tem certeza?",
            text: "Esta ação não poderá ser revertida!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#71717a",
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Excluindo...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    url: `/project/${id_project}`,
                    method: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        Swal.close();
                        $card.fadeOut(400, function () {
                            $(this).remove();

                            const Toast = Swal.mixin({
                                toast: true,
                                position: "bottom-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            Toast.fire({
                                icon: "success",
                                title: response.message || "Projeto removido!",
                            });
                        });
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Erro!",
                            "Não foi possível excluir.",
                            "error",
                        );
                    },
                });
            }
        });
    });

    $(".btn-copiar").on("click", function () {
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


function editarProjeto(id, nomeAtual) {
    Swal.fire({
        title: "Editar Projeto",
        html: `
            <div class="text-left">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Projeto</label>
                <input type="text" id="edit-project-name" class="w-full p-2 border border-gray-300 rounded-md outline-none focus:border-zinc-900" value="${nomeAtual}">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: "Salvar Alterações",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#18181b",
        preConfirm: () => {
            const name = document.getElementById("edit-project-name").value;
            if (!name) {
                Swal.showValidationMessage("O nome é obrigatório");
                return false;
            }
            return { name: name };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            atualizarProjeto(id, result.value.name);
        }
    });
}



function atualizarProjeto(id, novoNome) {
    Swal.fire({
        title: "Atualizando...",
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); },
    });

    $.ajax({
        url: `/project/${id}`, 
        method: "PATCH", 
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            name: novoNome,
        },
        success: function (response) {
            Swal.fire("Sucesso!", "Projeto atualizado.", "success")
                .then(() => location.reload());
        },
        error: function () {
            Swal.fire("Erro!", "Não foi possível atualizar.", "error");
        },
    });
}
