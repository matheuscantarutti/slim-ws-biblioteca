<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

require('env.php');

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'doctrine' => [
                'dev_mode'      => true,
                'cache_dir'     => __DIR__ . '/../var/cache/doctrine',
                'metadata_dirs' => [__DIR__ . '/../src/Domain/'],
                'connection'    => [
                    'driver'   => 'pdo_mysql',
                    'host'     => 'localhost',
                    'port'     => 3306,
                    'dbname'   => ENV_DOCTRINE_DBNAME,
                    'user'     => ENV_DOCTRINE_USER,
                    'password' => ENV_DOCTRINE_PASSWORD,
                    'charset'  => 'utf8'
                ],
            ]
        ],
    ]);
};
