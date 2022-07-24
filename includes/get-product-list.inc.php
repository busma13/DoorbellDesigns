<?php
include_once 'dbh.inc.php';

//Retrieve product list
$get_product_list_sql = 'SELECT * FROM products;';

/* Execute the query */
try
{
    $res = $pdo->prepare($get_product_list_sql);
    $res->execute();
    $rows = 0;
    $str = '';
    $productList = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $productList[] = $row;
        // $rows++;
        // $str .= $rows . ' ' . 'line' . "----"; //implode(', ', $row)
    }

    $response = $productList;
}
catch (PDOException $e)
{
    $msg = $e->getMessage();
    $response = $msg;
}

/* Send success to fetch API */
die(json_encode($response));