$(document).ready(function() {
    // Ativar/Desativar usuário
    $(document).on('click', '.desativar-ativar-usuario', function() {
        var userId = $(this).data('id');
        var btn = $(this);
        var cardUsuario = btn.closest('.div-usuario');
        var statusSpan = cardUsuario.find('.status');
        var statusAtual = statusSpan.text().trim();
        
        // Define a nova ação baseada no status atual
        var acao = (statusAtual === 'Ativo') ? 'desativar' : 'ativar';
        
        $.ajax({
            type: 'POST',
            url: '../../back/ativar-desativar-usuario.php',
            data: { 
                id_usuario: userId,
                acao: acao
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    console.log(response.message);
                    // Atualiza o status e o texto do botão
                    if (acao === 'desativar') {
                        statusSpan.text('Inativo');
                        btn.text('Ativar').addClass('btn-ativar');
                    } else {
                        statusSpan.text('Ativo');
                        btn.text('Desativar').removeClass('btn-ativar');
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao processar a solicitação');
            }
        });
    });
});