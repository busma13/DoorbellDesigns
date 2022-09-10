<?php
use Unirest\Response;
include_once 'dbh.inc.php';
require '../turbocommons-php-3.8.0.phar';
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

// //If the image changed, get the picture from the main image folder and copy and resize it into the other folders.
// if ($column === 'imgUrl') {
//   //format image to the 3 needed sizes
//   try {
//     resizer($uploadedFile, dirname(__FILE__, 2) . '/images' . '/' . strtolower($_POST['mainCategory']) . "-small/" . $imgUrl, [180, 200]);
//     resizer($uploadedFile, dirname(__FILE__, 2) . '/images' . '/' . strtolower($_POST['mainCategory']) . "-medium/" . $imgUrl, [720, 800]);
//     resizer($uploadedFile, dirname(__FILE__, 2) . '/images' . '/' . strtolower($_POST['mainCategory']) . "-large/" . $imgUrl, [1080, 1200]);    
//   } catch (Exception $err) {
//       $response = "image-resize error: " + $err;
//       die(json_encode($response));

//   }
// }
//TODO - test this if/else block
if ($column === 'itemNameString') {
        $itemName = StringUtils::formatCase($value, StringUtils::FORMAT_LOWER_CAMEL_CASE);
        $imgUrl = $itemName . '.jpg';

        //get values from updateProducts() and update a product
        $query = "UPDATE products SET itemNameString = :itemNameString, itemName = :itemName, imgUrl = :imgUrl WHERE id = :id;";

        // UPDATE `products` SET `itemNameString` = 'Heart Doorbell - Thin', `itemName` = 'heartDoorbellThin', `imgUrl` = 'heartDoorbellThin.jpg' WHERE id = '27';

        $values = array(':id' => $id, ':itemNameString' => $value, ':itemName' => $itemName, ':imgUrl' => $imgUrl);
} else {
        //get values from updateProducts() and update a product
        $query = "UPDATE products SET $column = :newValue WHERE id = :id;";

        $values = array(':id' => $id, ':newValue' => $value );

}


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