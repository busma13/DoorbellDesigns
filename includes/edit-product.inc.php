<?php
include_once 'dbh.inc.php';
require '../turbocommons-php-3.8.0.phar';

/* Get content type */
$contentType = trim($_SERVER["CONTENT_TYPE"] ?? ''); // PHP 8+
// Otherwise:
// $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

/* Send error to Fetch API, if unexpected content type */
if ($contentType !== "application/json")
  exit(json_encode([
    'value' => 0,
    'error' => 'Content-Type is not set as "application/json"',
    'data' => null,
  ]));

/* Receive the RAW post data. */
$content = trim(file_get_contents("php://input"));

/* $decoded can be used the same as you would use $_POST in $.ajax */
$decoded = json_decode($content, true);

/* Send error to Fetch API, if JSON is broken */
if(! is_array($decoded))
  exit(json_encode([
    'value' => 0,
    'error' => 'Received JSON is improperly formatted',
    'data' => null,
  ]));

$id = $decoded['id'];
$value = $decoded['value'];
$column = $decoded['column'];
//TODO - get values from updateProducts() and update a product
$query = "UPDATE products SET $column = :newValue WHERE id = :id;";

$values = array(':id' => $id, ':newValue' => $value, );

/* Execute the query */
try
{
    $res = $pdo->prepare($query);
    $success = $res->execute($values);
    // if ($success) {
    //     $row = $res->fetch(PDO::FETCH_ASSOC);
        // if ($row['itemNameString'] == '') {
        //     $response = 'not-found';
        // } else {
            $response = 'success';
        // }
    // }
    // else {
    //     // header("Location: ../admin-panel.php?editProduct=retrieve-fail#edit-form");
    //     $response = 'retrieve-fail';
    // }
}
catch (PDOException $e)
{
    $msg = $e->getMessage();
    $response = $msg . ' ' . $query;
    // header("Location: ../admin-panel.php?editProduct=query&code=" . $msg . "#edit-form");
    // exit();
}



/* Do something with received data and include it in response */
// dumb e.g.
// $response = $editProductName; 

/* Perhaps database manipulation here? */
// query, etc.

/* Send success to fetch API */
die(json_encode($response));