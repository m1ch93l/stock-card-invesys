<?php

$config = [
    'host'   => 'localhost',
    'user'   => 'root',
    'pass'   => '',
    'dbname' => '',
];

$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

if ($conn->connect_error) {
    die(json_encode([
        'error' => $conn->connect_error,
    ]));
}