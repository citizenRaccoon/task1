<?php

require_once '../classes/db/MySQLConnection.php';

$user = $_POST['user'];
$password = $_POST['password'];

$mysqlConection = new MySQLConnection();
$mysqlConection->connect();
$result = $mysqlConection->getAllFields('users', ['user' => $user, 'password' => hash('sha256', $password)]);

echo (bool)$result;