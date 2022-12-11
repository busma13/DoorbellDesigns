<?php
// database handler includes folder = dbh.inc.php

$host = $_SERVER['HTTP_HOST'];

if ($host === 'localhost') {
    $dbServername = "localhost"; //needs to point to actual online server 
    $dbUsername = "root"; //will be different for online server
    $dbPassword = ""; //xampp has no default pw
    $dbName = "doorbell_designs";
}
else {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $dbServername = $url["host"];
    $dbUsername = $url["user"];
    $dbPassword = $url["pass"];
    $dbName = substr($url["path"], 1);
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