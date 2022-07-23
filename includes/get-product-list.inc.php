<?php
include_once 'dbh.inc.php';

//Retrieve product list
$get_product_list_sql = 'SELECT * FROM products;';

/* Execute the query */
try
{
    $res = $pdo->prepare($get_product_list_sql);
    $res->execute();

    $productList = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $productList[] = $row;
    }

    $response = 'testing';
}
catch (PDOException $e)
{
    $msg = $e->getMessage();
    $response = $msg;
}

/* Send success to fetch API */
die(json_encode($response));