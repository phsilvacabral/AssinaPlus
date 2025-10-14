$(document).ready(function() {
    var editModal = document.getElementById('modal-editar-usuario');
    if (!editModal) return;

    function openEdit(){
        editModal.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
    }
    function closeEdit(){
        editModal.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
    }

    // Delegação para todos os botões Editar
    $(document).on('click', '.editar-usuario', function() {
        var userId = $(this).data('id');
        
        // Busca os dados do usuário via AJAX
        $.ajax({
            type: 'POST',
            url: '../../back/buscar-user.php',
            data: { id_usuario: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Preenche o formulário com os dados
                    $('#edit-user-id').val(response.data.id_usuario);
                    $('#edit-nome').val(response.data.nome);
                    $('#edit-email').val(response.data.email);
                    $('#edit-setor').val(response.data.id_setor);
                    $('#edit-perfil').val(response.data.id_tipo);
                    
                    openEdit();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao buscar dados do usuário');
            }
        });
    });

    // Fechar por backdrop/botão fechar
    editModal.addEventListener('click', function(e){
        if (e.target.hasAttribute('data-close')) closeEdit();
    });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') closeEdit();
    });

    // Botão Cancelar do formulário
    var cancelBtn = document.getElementById('btn-cancelar-edicao');
    if (cancelBtn) cancelBtn.addEventListener('click', closeEdit);

    // Submit do formulário
    $('#form-editar-usuario').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: '../../back/editar-user.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    closeEdit();
                    location.reload(); // Recarrega a página para mostrar os dados atualizados
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao atualizar usuário');
            }
        });
    });
});