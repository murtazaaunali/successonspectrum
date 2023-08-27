<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('SOS_DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('SOS_DB_DATABASE', database_path('database.sqlite')),
            'prefix' => env('SOS_DB_PREFIX', 'sos_'),
            'foreign_key_constraints' => env('SOS_DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('SOS_DB_HOST', '127.0.0.1'),
            'port' => env('SOS_DB_PORT', '3306'),
            'database' => env('SOS_DB_DATABASE', 'forge'),
            'username' => env('SOS_DB_USERNAME', 'forge'),
            'password' => env('SOS_DB_PASSWORD', ''),
            'unix_socket' => env('SOS_DB_SOCKET', ''),
            'charset' => env('SOS_DB_CHARSET', 'utf8mb4'),
            'collation' => env('SOS_DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('SOS_DB_PREFIX', 'sos_'),
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('SOS_MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('SOS_DB_HOST', '127.0.0.1'),
            'port' => env('SOS_DB_PORT', '5432'),
            'database' => env('SOS_DB_DATABASE', 'forge'),
            'username' => env('SOS_DB_USERNAME', 'forge'),
            'password' => env('SOS_DB_PASSWORD', ''),
            'charset' => env('SOS_DB_CHARSET', 'utf8'),
            'prefix' => env('SOS_DB_PREFIX', 'sos_'),
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('SOS_DB_HOST', 'localhost'),
            'port' => env('SOS_DB_PORT', '1433'),
            'database' => env('SOS_DB_DATABASE', 'forge'),
            'username' => env('SOS_DB_USERNAME', 'forge'),
            'password' => env('SOS_DB_PASSWORD', ''),
            'charset' => env('SOS_DB_CHARSET', 'utf8'),
            'prefix' => env('SOS_DB_PREFIX', 'sos_'),
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('SOS_REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('SOS_REDIS_CLUSTER', 'predis'),
        ],

        'default' => [
            'host' => env('SOS_REDIS_HOST', '127.0.0.1'),
            'password' => env('SOS_REDIS_PASSWORD', null),
            'port' => env('SOS_REDIS_PORT', 6379),
            'database' => env('SOS_REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('SOS_REDIS_HOST', '127.0.0.1'),
            'password' => env('SOS_REDIS_PASSWORD', null),
            'port' => env('SOS_REDIS_PORT', 6379),
            'database' => env('SOS_REDIS_CACHE_DB', 1),
        ],

    ],

];
