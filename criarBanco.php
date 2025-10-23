<?php
require_once __DIR__ . '/bootstrap.php'; 

use Doctrine\ORM\Tools\SchemaTool;

$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

$schemaTool = new SchemaTool($entityManager);

try {
    $sqls = $schemaTool->getUpdateSchemaSql($metadata, $full = true);

    if (empty($sqls)) {
        echo "Banco de dados já está sincronizado. Nenhuma alteração foi necessária.\n";
    } else {
        $schemaTool->updateSchema($metadata);
        echo "Banco de dados atualizado com sucesso (tabelas criadas ou modificadas)!";
    }

} catch (\Exception $e) {
    die("Ocorreu um erro ao tentar atualizar o esquema: " . $e->getMessage());
}