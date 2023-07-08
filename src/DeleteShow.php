<?php
include_once 'Dbh.php';

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

$deleteDate = $decoded['date'];

// $response = $editColumn;
$query = "DELETE FROM shows WHERE startDate = :deleteDate;";

/* Execute the query */
try {
  $res1 = $pdo->prepare($query);
  $res1->bindParam(':deleteDate', $deleteDate);
  $success = $res1->execute();

  if ($success) {
    $response = 'success';
  } else {
    $response = 'delete-failed';
  }
} catch (PDOException $e) {
  $msg = $e->getMessage();
  $response = $msg;
}

/* Send success to fetch API */
die(json_encode($response));