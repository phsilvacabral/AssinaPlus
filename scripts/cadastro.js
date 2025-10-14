$(document).ready(function() {
    $('#cadastroForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'back/cadastro.php',
            data: $(this).serialize(),
            dataType: 'json',
            
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    // Fechar o modal após sucesso
                    $('#backdrop').addClass('hidden');
                    $('#cadastroModal').addClass('hidden');
                    // Limpar o formulário
                    $('#cadastroForm')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: " + textStatus, errorThrown);
                alert('Ocorreu um erro ao tentar fazer o cadastro. Tente novamente.');
            }
        });
    });
});
