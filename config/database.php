<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', 'mysql_docker'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        // -------------------------------------------------------------
        // CONEXIÓN 1: Base de Datos en Docker (PC Y / Tu servidor)
        // -------------------------------------------------------------
        'mysql_docker' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_DOCKER_HOST', '127.0.0.1'),
            'port' => env('DB_DOCKER_PORT', '3306'),
            'database' => env('DB_DOCKER_DATABASE', 'escuela_docker'),
            'username' => env('DB_DOCKER_USERNAME', 'root'),
            'password' => env('DB_DOCKER_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // -------------------------------------------------------------
        // CONEXIÓN 2: Base de Datos del Docente (Red Local)
        // -------------------------------------------------------------
        'mysql_docente' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_DOCENTE_HOST', '192.168.x.x'),
            'port' => env('DB_DOCENTE_PORT', '3306'),
            'database' => env('DB_DOCENTE_DATABASE', 'escuela_docente'),
            'username' => env('DB_DOCENTE_USERNAME', 'docente'),
            'password' => env('DB_DOCENTE_PASSWORD', 'secret'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => 'migrations',

];