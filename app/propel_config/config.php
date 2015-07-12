<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use SecurityClasses\environ\LogVarHolder;

try {

    $username = getenv("DB_USERNAME");
    $password = getenv("DB_PASSWORD");
    $host = getenv("DB_HOST");
    $database = getenv("DB_DATABASE");

        $config_array_local = array(
            'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
            'dsn' => "mysql:host=$host;dbname=$database",
            'user' => $username,
            'password' => $password
        );
        $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
        $serviceContainer->checkVersion('2.0.0-dev');
        $serviceContainer->setAdapterClass('gom', 'mysql');
        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration($config_array_local);

        $manager->setName('gom');
        $serviceContainer->setConnectionManager('gom', $manager);
        $serviceContainer->setDefaultDatasource('gom');

} catch (\Exception $e) {
    error_log("Error initializing propel " . PHP_EOL . " " . $e->getMessage());
    echo "We are sorry. The gradeomatic is temporarily unavailable ";
    die();
}

