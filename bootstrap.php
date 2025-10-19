<?php

use Doctrine\DBAL\DriverManager; 
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . "/vendor/autoload.php";

$isDevMode = true;

// --- Configuração da Metadata (Entidades) ---
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/Classes"],
    isDevMode: $isDevMode,
);

// --- Configuração da Conexão com o Banco de Dados (ARRAY CLÁSSICO) ---
// CORREÇÃO: Usando o formato array com a chave 'driver' obrigatória.
$connectionParams = [
    'driver'    => 'pdo_mysql', // <--- ESSA CHAVE É OBRIGATÓRIA!
    'host'      => '127.0.0.1',
    'port'      => 3306,
    'dbname'    => 'ormgestaocontratos',
    'user'      => 'root',
    'password'  => 'PUC@1234',
    'charset'   => 'utf8mb4',
];


// --- CRIAÇÃO DO ENTITYMANAGER EM DUAS ETAPAS (FINAL E MAIS ROBUSTA) ---
try {
    // 1. Crie a CONEXÃO (Objeto Doctrine\DBAL\Connection)
    // O DriverManager agora tem a chave 'driver' que ele precisa.
    $connection = DriverManager::getConnection($connectionParams, $config); 
    // Nota: O $config é opcional aqui, mas incluído para manter o padrão se necessário

    // 2. Crie o ENTITY MANAGER
    $entityManager = new EntityManager($connection, $config);

} catch (\Exception $e) {
    // Apenas para visualização completa do erro
    die("Erro de configuração ou conexão: " . $e->getMessage());
}