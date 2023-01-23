<?php
include_once 'dbh.inc.php';

/* Get content type */
// $contentType = trim($_SERVER["CONTENT_TYPE"] ?? ''); // PHP 8+
// Otherwise:
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

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

$picInfo = $decoded['picInfo'];
$numberOfPics = $decoded['numberOfPics'];
$url = $picInfo['secure_url'];
$productId = $decoded['productId'];
$response =  $productId;

// Add url to imgUrls database
$query = "INSERT INTO imgUrls
              VALUES (:product_id, :url)";

$values = array(':product_id' => $productId, ':url' => $url);

/* Execute the query */
try {
  $res = $pdo->prepare($query);
  $success = $res->execute($values);
  // TODO: Update image count in products database

  $response = 'success';
} catch (PDOException $e) {
  $msg = $e->getMessage();
  $response = $msg . ' ' . $query;
}

/* Send success to fetch API */
die(json_encode($response));