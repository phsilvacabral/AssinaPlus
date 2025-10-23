<?php

use Doctrine\DBAL\DriverManager; 
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . "/vendor/autoload.php";

$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/Classes"],
    isDevMode: $isDevMode,
);

$connectionParams = [
    'driver'    => 'pdo_mysql', 
    'host'      => '127.0.0.1',
    'port'      => 3306,
    'dbname'    => 'ormgestaocontratos',
    'user'      => 'root',
    'password'  => 'PUC@1234',
    'charset'   => 'utf8mb4',
];

try {
    $connection = DriverManager::getConnection($connectionParams, $config); 
    $entityManager = new EntityManager($connection, $config);

} catch (\Exception $e) {
    die("Erro de configuração ou conexão: " . $e->getMessage());
}