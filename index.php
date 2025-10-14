<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
    <title>Assina+</title>
</head>

<body>
    <section id="login-cadastro">
        <h1 id="title">Assina+</h1>
        <p id="subtitle">Faça login para acessar o sistema de gestão de contratos</p>
        <div id="buttons">
            <div id="button-login">Fazer Login</div>
            <div id="button-cadastro"><img src="img/user-add.svg" alt="icone cadastrar"> &nbsp; Criar Conta</div>
        </div>
        <p id="msg-login">Não tem uma conta? Solicite seu cadastro</p>
    </section>

    <!-- Fundo escurecido -->
    <div id="backdrop" class="backdrop hidden"></div>

    <!-- Modal de Login -->
    <div id="loginModal" class="modal hidden">
        <div class="modal-header">
            <div class="close-button">&times;</div>
            <h2 class="title-modal"><img src="img/login.svg" alt="login"> &nbsp; Acesso ao Sistema</h2>
            <p class="subtitle-modal">Digite suas credenciais para acessar o sistema de gestão de contratos</p>
        </div>
        <div class="modal-body">
            <form id="loginForm">
                <label for="email">Usuário
                    <div class="input-container">
                        <img src="img/person.svg" alt="usuário" class="input-icon">
                        <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" required>
                    </div>
                </label>
                <label for="senha">Senha
                    <div class="input-container">
                        <img src="img/lock.svg" alt="senha" class="input-icon">
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>
                </label>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>

    <!-- Modal de Cadastro -->
    <div id="cadastroModal" class="modal hidden">
        <div class="modal-header">
            <div class="close-button">&times;</div>
            <h2 class="title-modal">Criar Conta</h2>
            <p class="subtitle-modal">Preencha os dados para solicitar acesso ao sistema</p>
        </div>
        <div class="modal-body">
            <form id="cadastroForm">
                <label for="nome">Nome Completo
                    <div class="input-container">
                        <img src="img/person.svg" alt="nome" class="input-icon">
                        <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                    </div>
                </label>

                <label for="email">Email
                    <div class="input-container">
                        <img src="img/mail.svg" alt="email" class="input-icon">
                        <input type="email" id="email" name="email" placeholder="seu.email@empresa.com" required>
                    </div>
                </label>
                
                <label for="usuario">Nome de Usuário 
                    <div class="input-container">
                        <img src="img/person-check-black.svg" alt="usuário" class="input-icon">
                        <input type="text" id="usuario" name="usuario" placeholder="nome_usuário" required>
                    </div>
                </label>
                
                <label for="senha">Senha
                    <div class="input-container">
                        <img src="img/lock.svg" alt="senha" class="input-icon">
                        <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
                    </div>
                </label>

                <label for="confirmarSenha">Confirmar senha
                    <div class="input-container">
                        <img src="img/lock.svg" alt="confirmar senha" class="input-icon">
                        <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
                    </div>
                </label>

                <label for="setor" class="label-select">
                    Selecione seu setor:
                    <select name="setor" id="setor" required>
                        <option value="Selecione">Selecione seu setor</option>
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

                <label for="tipoUsuario" class="label-select">Tipo de Usuário:
                    <select name="tipoUsuario" id="tipoUsuario">
                        <option value="Selecione">Selecione o tipo de usuário</option>
                        <option value="1">Solicitante</option>
                        <option value="2">Responsável</option>
                    </select>
                </label>
                <button type="submit">Solicitar Cadastro</button>
            </form>

            <span id="msg-modal-cadastro">Sua solicitação será analisada pelo administrador do sistema</span>
        </div>
    </div>

    <script>
        // Elementos
        const loginButton = document.getElementById('button-login');
        const cadastroButton = document.getElementById('button-cadastro');
        const loginModal = document.getElementById('loginModal');
        const cadastroModal = document.getElementById('cadastroModal');
        const backdrop = document.getElementById('backdrop');
        const closeButtons = document.querySelectorAll('.close-button');

        // Função para abrir um modal
        function openModal(modal) {
            backdrop.classList.remove('hidden');
            modal.classList.remove('hidden');
        }

        // Função para fechar todos os modais
        function closeModal() {
            backdrop.classList.add('hidden');
            loginModal.classList.add('hidden');
            cadastroModal.classList.add('hidden');
        }

        // Event Listeners
        loginButton.addEventListener('click', () => openModal(loginModal));
        cadastroButton.addEventListener('click', () => openModal(cadastroModal));
        
        // Fechar ao clicar no "X"
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                closeModal();
                localStorage.removeItem('ultimo_usuario');

                // Limpa apenas o campo de usuário
                document.getElementById('usuario').value = '';
            });
        });

        // Fechar ao clicar no fundo
        backdrop.addEventListener('click', () => {
            closeModal();
            localStorage.removeItem('ultimo_usuario');
            document.getElementById('usuario').value = '';
        });

        // Limpar campo usuário ao atualizar/fechar a página
        window.addEventListener('beforeunload', () => {
            localStorage.removeItem('ultimo_usuario');
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts/cadastro.js"></script>
    <script src="scripts/login.js"></script>
</body>
</html>
