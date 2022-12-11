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
if (!is_array($decoded))
  exit(json_encode([
    'value' => 0,
    'error' => 'Received JSON is improperly formatted',
    'data' => null,
  ]));

$oldDate = date("Y-m-d", strtotime($decoded['date']));
$editStartDate = date_create($decoded['startDateString']);
$editEndDate = date_create($decoded['endDateString']);
$editStartDateString = $editStartDate->format("M j Y");
$editEndDateString = $editEndDate->format("M j Y");
$editName = $decoded['name'];
$editLocation = $decoded['location'];
$editBooth = $decoded['booth'];
$newStartDate = date("Y-m-d", strtotime($decoded['startDateString']));
$newEndDate = date("Y-m-d", strtotime($decoded['endDateString']));

if ($decoded['column'] === 'scheduleStartDate') {
  if ($oldDate == $newStartDate) {
    $query = "INSERT INTO shows
                VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  startDate = :newStartDate, 
                  startDateString = :editStartDateString;";
  } else {
    $query = "INSERT INTO shows
                VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  startDate = :newStartDate, 
                  startDateString = :editStartDateString;
              DELETE FROM shows WHERE startDate = :oldDate;";
  }
} else if ($decoded['column'] === 'scheduleEndDate') {
  $query = "INSERT INTO shows
                VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  endDate = :newEndDate,
                  endDateString = :editEndDateString;";
} else if ($decoded['column'] === 'scheduleName') {
  $query = "INSERT INTO shows
                VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  name = :editName;";
} else if ($decoded['column'] === 'scheduleLocation') {
  $query = "INSERT INTO shows
                VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  location = :editLocation;";
} else if ($decoded['column'] === 'scheduleBooth') {
  $query = "INSERT INTO shows
              VALUES (:newStartDate, :newEndDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
              ON DUPLICATE KEY UPDATE
                booth = :editBooth;";
}

$values = array(':newStartDate' => $newStartDate, ':newEndDate' => $newEndDate, ':oldDate' => $oldDate, ':editStartDateString' => $editStartDateString, ':editEndDateString' => $editEndDateString, ':editName' => $editName, ':editLocation' => $editLocation, ':editBooth' => $editBooth);

/* Execute the query */
try {
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
} catch (PDOException $e) {
  $msg = $e->getMessage();
  $response = $msg . ' ' . $query . '     ' . $editStartDateString;
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