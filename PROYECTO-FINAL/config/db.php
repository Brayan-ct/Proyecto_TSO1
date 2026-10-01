<?php

$dbConfig = [
    'host'     => 'localhost',
    'dbname'   => 'si_if2',
    'user'     => 'root',
    'password' => '',
];

function getPDO(): PDO
{
    global $dbConfig;

    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4";

    return new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}