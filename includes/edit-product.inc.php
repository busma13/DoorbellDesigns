<?php
use Unirest\Response;
include_once 'dbh.inc.php';
require './stringUtils.php';
use org\turbocommons\src\main\php\utils\StringUtils;

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

if ($column === 'itemNameString') {
    $originalItemName = '';
    $mainCategory = '';
    // Get the product we are editing from database
    $query1 = "SELECT * FROM `products` WHERE id = :id;";

    /* Execute the get product query */
    try
    {
        $res = $pdo->prepare($query1);
        $res->bindParam(':id', $id);
        $success = $res->execute();
        if ($success) {
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if ($row['itemNameString'] == '') {
                $response = 'not-found';
            } else {
                $originalItemName = $row['itemName'];
                $mainCategory = $row['mainCategory'];
            }
        }
        else {
            $response = 'server-error';
            die(json_encode($response));
        }
    }
    catch (PDOException $e)
    {
        $msg = $e->getMessage();
        $response = $msg;
        // header("Location: ../admin-panel.php?editProduct=query&code=" . $msg . "#edit-form");
        // exit();
    }

    $itemName = StringUtils::formatCase($value, StringUtils::FORMAT_LOWER_CAMEL_CASE);
    $imgUrl = $itemName . '.jpg';
    $pictureRoute = dirname(__FILE__, 2) . '/images' . '/' . strtolower($mainCategory);

    // Rename each photo 
    if (!rename($pictureRoute . "-original/" . $originalItemName . '.jpg', $pictureRoute . "-original/" . $imgUrl)) {
      $response = "image-rename error original";
      die(json_encode($response));
    }
    if (!rename($pictureRoute . "-small/" . $originalItemName . '.jpg', $pictureRoute . "-small/" . $imgUrl)) {
        $response = "image-rename error small";
        die(json_encode($response));
    }
    if (!rename($pictureRoute . "-medium/" . $originalItemName . '.jpg', $pictureRoute . "-medium/" . $imgUrl)) {
      $response = "image-rename error medium";
      die(json_encode($response));
    }
    if (!rename($pictureRoute . "-large/" . $originalItemName . '.jpg', $pictureRoute . "-large/" . $imgUrl)) {
      $response = "image-rename error large";
      die(json_encode($response));
    }
    //get values from updateProducts() and update a product
    $query2 = "UPDATE products SET itemNameString = :itemNameString, itemName = :itemName, imgUrl = :imgUrl WHERE id = :id;";

    $values = array(':id' => $id, ':itemNameString' => $value, ':itemName' => $itemName, ':imgUrl' => $imgUrl);
} else {
    //get values from updateProducts() and update a product
    $query2 = "UPDATE products SET $column = :newValue WHERE id = :id;";

    $values = array(':id' => $id, ':newValue' => $value );
}

/* Execute the update product query */
try
{
    $res = $pdo->prepare($query2);
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

/* Send success to fetch API */
die(json_encode($response));