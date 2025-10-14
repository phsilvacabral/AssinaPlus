<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="shortcut icon" href="../img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>Assina+</h1>
        <p>Gestão Empresarial</p>
        <ul>
            <li><img src="../img/group.svg" alt="ícones de etapas">Usuários</li>
            <li><img src="../img/domain-black.svg" alt="ícone de etapas">Setores</li>
            <li><img src="../img/number-list.svg" alt="ícone de etapas">Etapas de Contratos</li>
            <li><img src="../img/layers.svg" alt="ícone de etapas">Grupos de Contratos</li>
        </ul>
        <div id="div-user">
            <div id="img-user">PH</div>
            <div id="div-nome-cargo">
                <span id="nome">Pedro Henrique</span>
                <span id="cargo">Administrador</span>
            </div>
            <div id="sair"><img src="../img/logout.svg" alt="ícone logout"></div>
        </div>
    </nav>

    <div id="div-iframe">
        <iframe src="usuarios/index.php" frameborder="0"></iframe>
    </div>

    <script>
        // Adiciona evento de clique no botão sair
        document.getElementById('sair').addEventListener('click', function() {
            if (confirm('Tem certeza que deseja sair do sistema?')) {
                window.location.href = '../back/logout.php';
            }
        });
    </script>
</body>
</html>