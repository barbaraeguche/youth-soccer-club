<?php

$hostname = 'pnc353.encs.concordia.ca';
$username = 'pnc353_1';
$password = '2024team';
$database = 'pnc353_1';
$port = 3306;

try {
    $conn = mysqli_connect($hostname, $username, $password, $database, $port);
} catch (Exception $e) {
    die('Connection failed: ' . mysqli_connect_error());
}