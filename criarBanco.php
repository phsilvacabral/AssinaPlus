<?php

// 1. O arquivo bootstrap.php deve ser carregado
require_once __DIR__ . '/bootstrap.php'; 

use Doctrine\ORM\Tools\SchemaTool;

// Obter as entidades mapeadas
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

// Criar o SchemaTool
$schemaTool = new SchemaTool($entityManager);

try {
    // 1. Gerar os comandos SQL necessários para criar ou atualizar o esquema.
    $sqls = $schemaTool->getUpdateSchemaSql($metadata, $full = true);

    if (empty($sqls)) {
        echo "Banco de dados já está sincronizado. Nenhuma alteração foi necessária.\n";
    } else {
        // 2. Executar os comandos SQL para criar/atualizar as tabelas
        $schemaTool->updateSchema($metadata);
        echo "Banco de dados atualizado com sucesso (tabelas criadas ou modificadas)!";
    }

} catch (\Exception $e) {
    // Captura exceções, como se a entidade não tivesse Metadata válida
    // Se a tabela já existir, updateSchema() resolve.
    die("Ocorreu um erro ao tentar atualizar o esquema: " . $e->getMessage());
}