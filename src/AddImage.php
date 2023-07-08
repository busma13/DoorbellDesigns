<?php
include_once 'Dbh.php';

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
if ($picInfo['original_filename']) {
  $title = $picInfo['original_filename'];
} else {
  $response = 'duplicate-file-name';
  die(json_encode($response));
}
$productId = $decoded['productId'];
$response = $productId;

// Add url to imgUrls database
$id = uniqid('ID', true);
$query1 = "INSERT INTO imgUrls (id, url, title, product_id)
              VALUES (:id, :url, :title, :product_id)";

$values1 = array(':id' => $id, ':url' => $url, ':title' => $title, ':product_id' => $productId);

/* Execute the query */
try {
  $res1 = $pdo->prepare($query1);
  $success1 = $res1->execute($values1);
  if ($success1) {
    $query2 = "UPDATE products SET numberOfPics = :newValue WHERE id = :product_id;";

    $values2 = array(':product_id' => $productId, ':newValue' => $numberOfPics);
    /* Execute the update image count query */
    try {
      $res1 = $pdo->prepare($query2);
      $success2 = $res1->execute($values2);
      if ($success2) {
        $response = 'success';
      }
    } catch (PDOException $e) {
      $msg = $e->getMessage();
      $response = 'Q2' . $msg . ' ' . $query2;
    }
  }

  $response = 'success';
} catch (PDOException $e) {
  $msg = $e->getMessage();
  $response = 'Q1' . $msg . ' ' . $query1;
}

/* Send success to fetch API */
die(json_encode($response));