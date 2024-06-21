$(document).ready(function() {
    // Preview image before form submission
    $('#imagem').change(function() {
        const file = this.files[0];

        // Verificar se um arquivo foi selecionado
        if (file) {
            const reader = new FileReader();

            // Quando o arquivo é lido pelo FileReader
            reader.onload = function(event) {
                // Remover imagem anterior, se houver
                $('#preview').remove();

                // Criar elemento de imagem para a pré-visualização
                $('<img>', {
                    src: event.target.result,
                    class: 'img-thumbnail mt-3',
                    id: 'preview',
                    width: '200px'
                }).appendTo('#imagem-preview');
            };

            // Ler o conteúdo do arquivo como URL de dados
            reader.readAsDataURL(file);
        }
    });

    // Adicionar novo campo de Formação
    $('#addFormacao').click(function() {
        $('<div>', {
            class: 'form-group added-formacao',
            html: '<label>Formação:</label>' +
                  '<input type="text" class="form-control" name="formacao[]" placeholder="Digite sua formação" required>'
        }).appendTo('#formacoes');
    });

    // Adicionar novo campo de Experiência
    $('#addExperiencia').click(function() {
        $('<div>', {
            class: 'form-group added-experiencia',
            html: '<label>Experiência:</label>' +
                  '<textarea class="form-control" name="experiencia[]" rows="3" placeholder="Digite sua experiência profissional"></textarea>'
        }).appendTo('#experiencias');
    });

    // Validar o formulário antes de enviar
    $('#cvForm').submit(function(e) {
        var isValid = true;

        // Verificar se os campos obrigatórios estão preenchidos
        $(this).find('input, textarea').each(function() {
            if ($(this).prop('required') && $.trim($(this).val()) === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault(); // Impede o envio do formulário se algum campo estiver vazio
        }
    });

    // Remover classes de erro ao focar nos campos
    $('input, textarea').focus(function() {
        $(this).removeClass('is-invalid');
    });

    // Função de impressão do currículo
    $('#printCV').click(function() {
        window.print();
    });
});
