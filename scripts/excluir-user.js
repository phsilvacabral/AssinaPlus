$(document).ready(function() {
    var deleteModal = document.getElementById('modal-excluir-usuario');
    var deleteNameSpan = document.getElementById('confirm-user-name');
    var confirmBtn = document.getElementById('btn-confirmar-excluir');
    var userIdToDelete = null; // Variável para armazenar o ID do usuário a ser excluído
    
    if (!deleteModal || !deleteNameSpan) return;

    function openDelete(name, userId){
        deleteNameSpan.textContent = name || 'Usuário';
        userIdToDelete = userId; // Armazena o ID do usuário
        deleteModal.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDelete(){
        deleteModal.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
        userIdToDelete = null; // Limpa o ID
    }

    // Abrir a partir dos botões de excluir
    var deleteButtons = document.querySelectorAll('.div-usuario .excluir-usuario');
    deleteButtons.forEach(function(btn){
        btn.addEventListener('click', function(){
            var card = btn.closest('.div-usuario');
            var name = card ? (card.querySelector('.nome')?.textContent || 'Usuário') : 'Usuário';
            var userId = card ? card.getAttribute('idUser') : null;
            openDelete(name, userId);
        });
    });

    // Fechamento
    deleteModal.addEventListener('click', function(e){
        if (e.target.hasAttribute('data-close')) closeDelete();
    });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') closeDelete();
    });

    // Confirmação de exclusão
    if (confirmBtn){
        confirmBtn.addEventListener('click', function(){
            if (userIdToDelete) {
                // Desabilita o botão para evitar múltiplos cliques
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Excluindo...';
                
                // Faz a requisição AJAX para excluir o usuário
                $.ajax({
                    url: '../../back/excluir-user.php',
                    type: 'POST',
                    data: {
                        id_usuario: userIdToDelete
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log(response.message);
                            // Remove o elemento do usuário da página
                            var userCard = document.querySelector(`[idUser="${userIdToDelete}"]`);
                            if (userCard) {
                                userCard.remove();
                            }
                            // Atualiza o contador de usuários
                            var totalUsers = document.querySelectorAll('.div-usuario').length;
                            document.getElementById('resumo').textContent = `Mostrando ${totalUsers} usuários`;
                        } else {
                            alert('Erro: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Erro ao excluir usuário. Tente novamente.');
                    },
                    complete: function() {
                        // Reabilita o botão
                        confirmBtn.disabled = false;
                        confirmBtn.textContent = 'Excluir';
                        closeDelete();
                    }
                });
            }
        });
    }
});