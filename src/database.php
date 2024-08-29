<?php

$hostname = 'enter your hostname';
$username = 'enter your username';
$password = 'enter your password';
$database = 'enter your database';
$port = 'enter port number';

try {
    $conn = mysqli_connect($hostname, $username, $password, $database, $port);
} catch (Exception $e) {
    die('Connection failed: ' . mysqli_connect_error());
}
