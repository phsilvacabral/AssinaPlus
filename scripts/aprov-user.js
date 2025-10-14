$(document).ready(function() {
    var openBtn = document.getElementById('div-aprov-solic');
    var modal = document.getElementById('modal-aprov-solic');
    if (!openBtn || !modal) return;

    function openModal() {
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        // Remove o card de exemplo do HTML ao abrir
        $('.req-card').remove();
        carregarSolicitacoes();
    }

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Carrega as solicitações pendentes
    function carregarSolicitacoes() {
        // Esconde o modal-empty inicialmente
        $('#modal-empty').hide();
        
        $.ajax({
            type: 'GET',
            url: '../../back/listar-solicitacoes.php',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Limpa cards anteriores
                    $('.req-card').remove();
                    
                    if (response.data.length > 0) {
                        $('.modal-subtitle').text(response.data.length + ' solicitação(ões) pendente(s)');
                        
                        // Cria um card para cada solicitação
                        response.data.forEach(function(user) {
                            var iniciais = obterIniciais(user.nome);
                            var card = criarCard(user, iniciais);
                            $('#modal-empty').before(card);
                        });
                    } else {
                        $('.modal-subtitle').text('Nenhuma solicitação pendente');
                        $('#modal-empty').show();
                    }
                }
            },
            error: function() {
                alert('Erro ao carregar solicitações');
                $('#modal-empty').show();
            }
        });
    }

    // Obtém iniciais do nome
    function obterIniciais(nome) {
        var nomes = nome.split(' ');
        var iniciais = nomes[0].charAt(0).toUpperCase();
        if (nomes.length > 1) {
            iniciais += nomes[1].charAt(0).toUpperCase();
        }
        return iniciais;
    }

    // Cria o HTML do card
    function criarCard(user, iniciais) {
        return `
            <div class="req-card" data-user-id="${user.id_usuario}">
                <div class="req-accent"></div>
                <div class="req-content">
                    <div class="req-header">
                        <div class="req-user">
                            <div class="req-avatar">${iniciais}</div>
                            <div class="req-ident">
                                <div class="req-name">${user.nome}</div>
                                <div class="req-email">${user.email}</div>
                            </div>
                        </div>
                        <span class="badge badge-pendente">Pendente</span>
                    </div>
                    
                    <div class="req-meta">
                        <div class="req-field"><span class="label">Perfil:</span><span class="value">${user.nomePerfil || 'Não informado'}</span></div>
                        <div class="req-field"><span class="label">Setor:</span><span class="value">${user.nome_setor || 'Não informado'}</span></div>
                        <span class="badge badge-solicitante">${user.tipo_usuario || 'Solicitante'}</span>
                    </div>
                    
                    <div class="req-actions">
                        <button type="button" class="btn btn-approve" data-id="${user.id_usuario}"><img src="../../img/check.svg" alt="">Aprovar</button>
                        <button type="button" class="btn btn-reject" data-id="${user.id_usuario}"><img src="../../img/close.svg" alt="">Rejeitar</button>
                    </div>
                </div>
            </div>
        `;
    }

    // Aprovar solicitação
    $(document).on('click', '.btn-approve', function() {
        var userId = $(this).data('id');
        var card = $(this).closest('.req-card');
        
        $.ajax({
            type: 'POST',
            url: '../../back/processar-solicitacao.php',
            data: { 
                id_usuario: userId,
                acao: 'aprovar'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    card.fadeOut(300, function() {
                        $(this).remove();
                        verificarCardsRestantes();
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao aprovar solicitação');
            }
        });
    });

    // Rejeitar solicitação
    $(document).on('click', '.btn-reject', function() {
        var userId = $(this).data('id');
        var card = $(this).closest('.req-card');
        
        $.ajax({
            type: 'POST',
            url: '../../back/processar-solicitacao.php',
            data: { 
                id_usuario: userId,
                acao: 'rejeitar'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    card.fadeOut(300, function() {
                        $(this).remove();
                        verificarCardsRestantes();
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao rejeitar solicitação');
            }
        });
    });

    // Verifica se ainda existem cards
    function verificarCardsRestantes() {
        if ($('.req-card').length === 0) {
            $('.modal-subtitle').text('Nenhuma solicitação pendente');
            $('#modal-empty').show();
        } else {
            $('.modal-subtitle').text($('.req-card').length + ' solicitação(ões) pendente(s)');
        }
    }

    openBtn.addEventListener('click', openModal);
    modal.addEventListener('click', function(e) {
        if (e.target.hasAttribute('data-close')) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});