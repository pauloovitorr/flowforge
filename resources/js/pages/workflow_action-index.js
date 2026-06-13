$(function () {
    $(".btn-excluir").on("click", function () {
        let $card = $(this).closest(".container-template");
        let id_action = $card.data("id");

        Swal.fire({
            title: "Tem certeza?",
            text: "Esta ação irá excluir a action. Ação não pode ser revertida!",
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
                    url: `/workflow_action/${id_action}`,
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
                                title: response.message || "Template removido!",
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
});
