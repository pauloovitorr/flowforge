$(function () {

    // Inicializa o Quill
    const quill = new Quill("#quill-editor", {
    theme: "snow",
    modules: {
        toolbar: {
            container: [
                ['bold', 'italic', 'underline'],
                ['link', 'image'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['clean']
            ],
            handlers: {
                image: function() {
                    const range = this.quill.getSelection();
                    const url = prompt('Cole a URL da imagem aqui:');
                    
                    if (url) {
                        this.quill.insertEmbed(range.index, 'image', url);
                    }
                }
            }
        },
    },
    placeholder: "Escreva o conteúdo do email aqui...",
});


    // Carrega valor antigo (old('body'))
    const oldBody = $("#template-body").val();
    if (oldBody && oldBody.trim() !== "") {
        quill.root.innerHTML = oldBody;
    }

    // Atualiza o input hidden sempre que o usuário digitar ou formatar
    quill.on("text-change", function () {
        $("#template-body").val(quill.root.innerHTML);
    });

   $("#quill-editor").on("click", function (e) {
        if (!$(e.target).closest('.ql-toolbar').length) {
            quill.focus();
        }
    });


});