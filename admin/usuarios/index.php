<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php 
include '../../connection.php'
?>
<body>
    <section id="header"">
        <div>
            <h1>Gestão de Usuários</h1>
            <p>Gerencie usuários e suas permissões no sistema</p>
        </div>

        <div id="div-aprov-solic"> <img src="../../img/person-check.svg" alt="">Aprovar Solicitações</div>
    </section>

    <!-- Modal Editar Usuário -->
    <div class="modal" id="modal-editar-usuario" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-backdrop" data-close></div>
        <div class="modal-dialog" role="document">
            <button class="modal-close" aria-label="Fechar" data-close>×</button>

            <div class="modal-header">
                <span class="modal-icon" aria-hidden="true"><img src="../../img/person.svg" alt="ícone de usuário"></span>
                <div class="modal-title-group">
                    <h2 class="modal-title">Editar Usuário</h2>
                    <p class="modal-subtitle">Atualize as informações do usuário</p>
                </div>
            </div>

            <div class="modal-body">
                <form id="form-editar-usuario">
                    <input type="hidden" id="edit-user-id" name="id_usuario">
                    <label for="edit-nome">Nome Completo
                        <div class="input-container">
                            <img src="../../img/person.svg" alt="nome" class="input-icon">
                            <input type="text" id="edit-nome" name="nome" placeholder="Nome completo" required>
                        </div>
                    </label>

                    <label for="edit-email">Email
                        <div class="input-container">
                            <img src="../../img/mail.svg" alt="email" class="input-icon">
                            <input type="email" id="edit-email" name="email" placeholder="email@empresa.com" required>
                        </div>
                    </label>

                    <label for="edit-setor" class="label-select">Setor
                        <select id="edit-setor" name="setor" required>
                            <option value="1">Administrativo</option>
                            <option value="2">Compras</option>
                            <option value="3">Financeiro</option>
                            <option value="4">RH</option>
                            <option value="5">TI</option>
                            <option value="6">Juridico</option>
                            <option value="7">Logística</option>
                            <option value="8">Marketing</option>
                            <option value="9">Sustentabilidade</option>
                            <option value="10">Comercial</option>
                        </select>
                    </label>

                    <label for="edit-perfil" class="label-select">Perfil
                        <select id="edit-perfil" name="perfil" required>
                            <option value="1">Solicitante</option>
                            <option value="2">Responsável</option>
                        </select>
                    </label>

                    <div class="edit-actions">
                        <button type="submit" class="modal-primary" id="btn-salvar-edicao">Atualizar</button>
                        <button type="button" class="modal-primary" data-close id="btn-cancelar-edicao">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Exclusão -->
    <div class="modal" id="modal-excluir-usuario" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-backdrop" data-close></div>
        <div class="modal-dialog" role="document">
            <button class="modal-close" aria-label="Fechar" data-close>×</button>

            <div class="confirm-delete">
                <div class="confirm-header">
                    <span class="confirm-icon" aria-hidden="true"><img src="../../img/warning.svg" alt="ícone de alerta"></span>
                    <h2 class="confirm-title">Confirmar Exclusão</h2>
                </div>
                <p class="confirm-text">Tem certeza que deseja excluir o usuário <strong id="confirm-user-name">Usuário</strong>? Esta ação não pode ser desfeita.</p>

                <div class="confirm-actions">
                    <button type="button" class="btn-secondary" data-close>Cancelar</button>
                    <button type="button" class="btn-danger" id="btn-confirmar-excluir">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Aprovar Solicitações -->
    <div class="modal" id="modal-aprov-solic" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-backdrop" data-close></div>
        <div class="modal-dialog" role="document">
            <button class="modal-close" id="modal-close" aria-label="Fechar" data-close>×</button>

            <div class="modal-header">
                <span class="modal-icon" aria-hidden="true"><img src="../../img/person-check-black.svg" alt="ícone de usuário"></span>
                <div class="modal-title-group">
                    <h2 class="modal-title">Aprovar Solicitações de Cadastro</h2>
                    <p class="modal-subtitle">Nenhuma solicitação pendente</p>
                </div>
            </div>

            <div class="modal-body">


            <div class="req-card">
                    <div class="req-accent"></div>
                    <div class="req-content">
                        <div class="req-header">
                            <div class="req-user">
                                <div class="req-avatar">ph</div>
                                <div class="req-ident">
                                    <div class="req-name">ytgvivyyyvi</div>
                                    <div class="req-email">pedro@gmail.com</div>
                                </div>
                            </div>
                            <span class="badge badge-pendente">Pendente</span>
                        </div>

                        <div class="req-meta">
                            <div class="req-field"><span class="label">Usuário:</span><span class="value">ycutyytu</span></div>
                            <div class="req-field"><span class="label">Setor:</span><span class="value">Administrativo</span></div>
                            <span class="badge badge-solicitante">Solicitante</span>
                        </div>

                        <div class="req-actions">
                            <button type="button" class="btn btn-approve"><img src="../../img/check.svg" alt="">Aprovar</button>
                            <button type="button" class="btn btn-reject"><img src="../../img/close.svg" alt="">Rejeitar</button>
                        </div>

                    </div>
                </div>


                <div id="modal-empty">
                    <img src="../../img/person-check-black.svg" alt="ícone de usuário">
                    <p>Nenhuma solicitação de cadastro pendente</p>
                </div>
            </div>


            <hr class="req-divider"/>
            <div class="modal-footer">
                <button type="button" class="modal-primary" data-close>Fechar</button>
            </div>
        </div>
    </div>

    <!-- Modal Pesquisa e Filtros-->
    <section id="pesquisa-filtros">
        <input type="text" id="barra-pesquisa" placeholder="Buscar usuários...">
        <select name="filtro-setores" id="filtro-setores">
            <option value="Todos">Todos os Setores</option>
            <option value="Administrativo">Administrativo</option>
            <option value="Compras">Compras</option>
            <option value="Financeiro">Financeiro</option>
            <option value="RH">RH</option>
            <option value="TI">TI</option>
            <option value="Juridico">Juridico</option>
            <option value="Logistica">Logística</option>
            <option value="Marketing">Marketing</option>
            <option value="Sustentabilidae">Sustentabilidade</option>
            <option value="Comercial">Comercial</option>
        </select>
        <select name="filtro-perfis" id="filtro-perfis">
            <option value="Todos">Todos os Perfis</option>
            <option value="Administrador">Administrador</option>
            <option value="Responsável">Responsável</option>
            <option value="Solicitante">Solicitante</option>
        </select>
    </section>
    
    <!-- Lista de Usuários -->
    <section id="usuarios"> 
        <?php
            $sql = "SELECT u.id_usuario, u.nome, u.email, u.nomePerfil, u.statusUsuario, s.nome 
                as nome_setor, t.Nome as tipo_usuario
                FROM Usuario u
                LEFT JOIN Setor s ON u.id_setor = s.id_setor
                LEFT JOIN TipoUsuario t ON u.id_tipo = t.id_tipo
                WHERE u.statusUsuario <> 'Pendente'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Pega as iniciais do nome
                $nomes = explode(' ', $row['nome']);
                $iniciais = strtoupper(substr($nomes[0], 0, 1));
                if (isset($nomes[1])) {
                    $iniciais .= strtoupper(substr($nomes[1], 0, 1));
                }
                
                $nome_setor = $row['nome_setor'] ?? 'Sem setor';
                $tipo_usuario = $row['tipo_usuario'] ?? 'Sem tipo';
                $status = $row['statusUsuario'];
                $botao_texto = ($status == 'Ativo') ? 'Desativar' : 'Ativar';
                $botao_classe = ($status == 'Ativo') ? '' : 'btn-ativar';
                ?>
                
                <div class="div-usuario" idUser="<?php echo $row['id_usuario']; ?>">
                    <div class="div-dados-usuario">
                        <div class="img-user"><?php echo $iniciais; ?></div>
                        <div class="div-nome-email">
                            <span class="nome"><?php echo htmlspecialchars($row['nome']); ?></span>
                            <span class="email"><?php echo htmlspecialchars($row['nomePerfil']); ?></span>
                        </div>   
                    </div>

                    <div class="div-setor-cargo">
                        <span class="setor"><img src="../../img/domain.svg" alt="ícone setor"><?php echo htmlspecialchars($nome_setor); ?></span>
                        <div class="div-cargo-status">
                            <span class="cargo"><?php echo htmlspecialchars($tipo_usuario); ?></span>
                            <span class="status"><?php echo htmlspecialchars($status); ?></span>
                        </div>
                    </div>

                    <div class="botoes-usuario">
                        <button type="button" class="editar-usuario" data-id="<?php echo $row['id_usuario']; ?>"><img src="../../img/edit.svg" alt="ícone de edição"> Editar</button>
                        <button type="button" class="desativar-ativar-usuario <?php echo $botao_classe; ?>" data-id="<?php echo $row['id_usuario']; ?>"><?php echo $botao_texto; ?></button>
                        <button type="button" class="excluir-usuario" data-id="<?php echo $row['id_usuario']; ?>"><img src="../../img/delete.svg" alt="ícone de deleção"></button>
                    </div>
                </div>        
                <?php
            }
        } else {
            echo "<p>Nenhum usuário cadastrado.</p>";
        }
        $conn->close();
        ?>
    </section>


    <span id="resumo">Mostrando <?php echo $result->num_rows ?> usuários </span>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../scripts/aprov-user.js"></script>
    <script src="../../scripts/excluir-user.js"></script>
    <script src="../../scripts/editar-user.js"></script>
    <script src="../../scripts/ativar-desativar-user.js"></script>
</body>
</html>