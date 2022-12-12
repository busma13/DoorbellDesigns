<?php
// database handler includes folder = dbh.inc.php

$dbServername = "colleendossey.ipowermysql.com";
$dbUsername = "peterluitjens"; 
$dbPassword = "bUqp3rn@N"; 
$dbName = "doorbell_designs";

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