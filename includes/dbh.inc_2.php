<?php
// database handler includes folder = dbh.inc.php

// $URL_REF = parse_url($_SERVER['HTTP_REFERER']);
// $URL_REF_HOST =   $URL_REF['host'];

// if ($URL_REF_HOST) {
//     $a = 'if';
    // $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    // $dbServername = $url["host"];
    // $dbUsername = $url["user"];
    // $dbPassword = $url["pass"];
    // $dbName = substr($url["path"], 1);

// }
// else {
    // $a = 'else';
    $dbServername = "localhost"; //needs to point to actual online server 
    $dbUsername = "root"; //will be different for online server
    $dbPassword = ""; //xampp has no default pw
    $dbName = "doorbell_designs";

// }
    
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);


