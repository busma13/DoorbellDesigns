<?php

require __DIR__ . '/../vendor/autoload.php';
// database handler includes folder = dbh.inc.php
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_SERVER['HTTP_HOST'];
if ($host === 'localhost') {
    $dbServername = "localhost"; //needs to point to actual online server 
    $dbUsername = "root"; //will be different for online server
    $dbPassword = ""; //xampp has no default pw
    $dbName = "doorbell_designs";
}
else {
   $dbServername = $_ENV['DB_SERVER_NAME'];
   $dbUsername = $_ENV['DB_USER_NAME'];
   $dbPassword = $_ENV['DB_PASSWORD'];
   $dbName = $_ENV['DB_NAME'];

}

$pdo = NULL;

/* Connection string, or "data source name" */
$dsn = 'mysql:host=' . $dbServername . ';dbname=' . $dbName . ';**charset=utf8**';
/* Connection inside a try/catch block */
try
{  
   /* PDO object creation */
   $pdo = new PDO($dsn, $dbUsername,  $dbPassword);
   /* Enable exceptions on errors */
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
   /* If there is an error an exception is thrown */
   echo 'Database connection failed.';
   die();
}