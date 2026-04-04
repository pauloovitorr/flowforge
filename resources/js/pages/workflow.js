import Swal from "sweetalert2";

$(function () {
    $("#project").select2({
        placeholder: "Selecione um projeto",
        width: "100%",
    });
});

$(".btn-excluir").on("click", function () {
    let $card = $(this).closest(".workflow");
    let id_workflow = $card.data("id");

    Swal.fire({
        title: "Tem certeza?",
        text: "Esta ação irá excluir o workflow e tudo ligado a ele. Ação não pode ser revertida!",
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
                url: `/workflow/${id_workflow}`,
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
                    
                    Swal.fire("Erro!", xhr.responseJSON.message, "error");
                },
            });
        }
    });

});
