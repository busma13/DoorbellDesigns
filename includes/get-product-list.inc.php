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

    $response = array();
    $response[] = $productList;
}
catch (PDOException $e)
{
    $msg = $e->getMessage();
    $response = $msg;
}

$json = json_encode($response);
if (!$json) {
    die(json_encode(json_last_error()));
}
/* Send success to fetch API */
die($json);