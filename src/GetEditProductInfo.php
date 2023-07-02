<?php
include_once 'Dbh.php';
use App\StringUtils;


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
if (!is_array($decoded))
  exit(json_encode([
    'value' => 0,
    'error' => 'Received JSON is improperly formatted',
    'data' => null,
  ]));


$editProductName = StringUtils::formatCase($decoded['name'], StringUtils::FORMAT_LOWER_CAMEL_CASE);

$query = "SELECT * FROM `products` WHERE itemName = :editProductName;";

/* Execute the query */
try {
  $res1 = $pdo->prepare($query);
  $res1->bindParam(':editProductName', $editProductName);
  $success = $res1->execute();
  if ($success) {
    $row = $res1->fetch(PDO::FETCH_ASSOC);
    if ($row['itemNameString'] == '') {
      $response = 'not-found';
    } else {
      $response = $row;
    }
  } else {
    // header("Location: ../admin-panel.php?editProduct=retrieve-fail#edit-form");
    $response = 'retrieve-fail';
  }
} catch (PDOException $e) {
  $msg = $e->getMessage();
  $response = $msg;
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