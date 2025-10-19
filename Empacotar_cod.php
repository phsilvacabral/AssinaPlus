<?php
$pharFile = 'AssinaPlus.phar';

// Remove o arquivo se ele já existir
if (file_exists($pharFile)) {
    unlink($pharFile);
}

try {
    // Cria o PHAR
    $phar = new Phar($pharFile);

    // Inicia buffering
    $phar->startBuffering();

    // Adiciona todos os arquivos da pasta atual 
    $phar->buildFromDirectory(__DIR__ );

    // Define o script de inicialização (pode ser o index.php)
    $phar->setStub($phar->createDefaultStub('index.php'));

    // Finaliza o empacotamento
    $phar->stopBuffering();

    echo "Arquivo PHAR criado com sucesso: $pharFile\n";
} catch (Exception $e) {
    echo "Erro ao criar PHAR: " . $e->getMessage();
}
