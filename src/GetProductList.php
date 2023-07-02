<?php
include_once 'Dbh.php';
//Retrieve product list
$get_product_list_sql = 'SELECT * FROM products;';

try {
    $res1 = $pdo->prepare($get_product_list_sql);
    $res1->execute();
    $rows = 0;
    $str = '';
    $productList = array();
    while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
        // retrieve image urls
        $get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " . $row['id'] . ";";

        try {
            $res2 = $pdo->prepare($get_image_urls_sql);
            $res2->execute();
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        $urlsArray = array();
        while ($urlRow = $res2->fetch(PDO::FETCH_ASSOC)) {
            $urlsArray[] = $urlRow['url'];
        }
        $row['urlsArray'] = $urlsArray;

        $productList[] = $row;
        // $rows++;
        // $str .= $rows . ' ' . 'line' . "----"; //implode(', ', $row)
    }

    $response = $productList;
} catch (PDOException $e) {
    $msg = $e->getMessage();
    $response = $msg;
}

/* Send success to fetch API */
die(json_encode($response));