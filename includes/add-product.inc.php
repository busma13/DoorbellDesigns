<?php
include_once 'dbh.inc.php';
require './stringUtils.php';
use org\turbocommons\src\main\php\utils\StringUtils;

if (isset($_POST['addProduct'])) {
  // echo __DIR__ . '<br>';
  // print_r($_FILES);
  // echo $_FILES['image']['name'] . '<br>';
  if (empty($_POST['itemNameString']) || empty($_POST['mainCategory']) || empty($_POST['priceSingle']) || empty($_POST['shipping']) || empty($_POST['dimensions'])) {
    header("Location: ../admin-panel.php?addProduct=empty#add-form");
    // echo $_POST['itemNameString'] . '<br>';
    // echo $_POST['mainCategory'] . '<br>';
    // echo $_POST['price'] . '<br>';
    // echo $_POST['shipping'] . '<br>';
    // echo $_POST['dimensions'] . '<br>';
    // echo $_POST['subCategories'] . '<br>';
    exit();
  } else {
    $itemNameString = $_POST['itemNameString'];
    $itemName = StringUtils::formatCase($itemNameString, StringUtils::FORMAT_LOWER_CAMEL_CASE);
    $subCategories = json_encode(explode(', ', $_POST['subCategories'])) ?? '';
    $optionIDs = json_encode($_POST['optionIDs']);
    $priceArray = array($_POST['priceSingle']);
    if ($_POST['pricePair']) {
      array_push($priceArray, $_POST['pricePair']);
    }
    $priceArray = json_encode($priceArray);
    $addActive = $_POST['addActive'] ?? '0';
    $addFeatured = $_POST['addFeatured'] ?? '0';

    //Enter everything into the database
    $query =
      "INSERT INTO products (itemName, itemNameString, mainCategory, subCategories, priceArray, shipping, optionIDs, qtyInCart, dimensions, active, featured) VALUES (:itemName,:itemNameString,:mainCategory,:subCategories,:priceArray,:shipping, :optionIDs,:qtyInCart,:dimensions, :addActive, :addFeatured);";

    /* Values array for PDO */
    $values = array(':itemName' => $itemName, ':itemNameString' => $itemNameString, ':mainCategory' => $_POST['mainCategory'], ':subCategories' => $subCategories, ':priceArray' => $priceArray, ':shipping' => $_POST['shipping'], 'optionIDs' => $optionIDs, ':qtyInCart' => 0, ':dimensions' => $_POST['dimensions'], ':addActive' => $addActive, ':addFeatured' => $addFeatured);

    // echo $_POST['itemNameString'] . '<br>';
    // echo $itemName . '<br>';
    // echo $_POST['mainCategory'] . '<br>';
    // echo print_r($subCategories) . '<br>';
    // echo $_POST['price'] . '<br>';
    // echo $_POST['shipping'] . '<br>';
    // echo $_POST['dimensions'] . '<br>';

    /* Execute the query */
    try {
      $res1 = $pdo->prepare($query);
      $res1->execute($values);
      $retVal = $pdo->lastInsertId();

      header("Location: ../admin-panel.php?addProduct=success#add-form");

    } catch (PDOException $e) {
      $msg = $e->getMessage();
      header("Location: ../admin-panel.php?addProduct=query&code=" . $msg . "#add-form");
      exit();
    }
  }
} else {
  header("Location: ../admin-panel.php?addProduct=error");
  exit();
}