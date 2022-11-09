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

$oldDate = $decoded['date'];
$editStartDateString = $decoded['startDateString'];
$editEndDateString = $decoded['endDateString'];
$editName = $decoded['name'];
$editLocation = $decoded['location'];
$editBooth = $decoded['booth'];
$newDate = date("Y-m-d", strtotime($decoded['startDateString']));

if ($decoded['column'] === 'scheduleStartDateString') {   
    $query = "INSERT INTO shows
                VALUES (:newDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  date = :newDate, 
                  startDateString = :editStartDateString;
              DELETE FROM shows WHERE date = :oldDate;";
} else if ($decoded['column'] === 'scheduleEndDateString') {   
    $query = "INSERT INTO shows
                VALUES (:newDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  endDateString = :editEndDateString;";
} else if ($decoded['column'] === 'scheduleName') {
    $query = "INSERT INTO shows
                VALUES (:newDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
                ON DUPLICATE KEY UPDATE
                  name = :editName;";
} else if ($decoded['column'] === 'scheduleLocation') {
    $query = "INSERT INTO shows
                VALUES (:newDate, :editStartDateString, :editEndDateString, :editName, :editLocation)
                ON DUPLICATE KEY UPDATE
                  location = :editLocation;";
} else if ($decoded['column'] === 'scheduleBooth') {
  $query = "INSERT INTO shows
              VALUES (:newDate, :editStartDateString, :editEndDateString, :editName, :editLocation, :editBooth)
              ON DUPLICATE KEY UPDATE
                booth = :editBooth;";
}

$values = array(':newDate' => $newDate, ':oldDate' => $oldDate, ':editStartDateString' => $editStartDateString, ':editEndDateString' => $editEndDateString, ':editName' => $editName, ':editLocation' => $editLocation, ':editBooth' => $editBooth);

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