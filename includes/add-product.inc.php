<?php
include_once 'dbh.inc.php';
require './stringUtils.php';
use org\turbocommons\src\main\php\utils\StringUtils;

if (isset($_POST['addProduct'])) {
  // echo __DIR__ . '<br>';
  // print_r($_FILES);
  // echo $_FILES['image']['name'] . '<br>';
  if (empty($_POST['itemNameString']) || empty($_POST['mainCategory']) || empty($_POST['price']) || empty($_POST['shipping']) || empty($_POST['dimensions']) || empty($_FILES['image']['name'])) {
    header("Location: ../admin-panel.php?addProduct=empty#add-form");
    // echo $_POST['itemNameString'] . '<br>';
    // echo $_POST['mainCategory'] . '<br>';
    // echo $_POST['price'] . '<br>';
    // echo $_POST['shipping'] . '<br>';
    // echo $_POST['dimensions'] . '<br>';
    // echo $_POST['subCategories'] . '<br>';
    // echo $_FILES['image']['name'] . '<br>';
    exit();
  } else {
    $itemNameString = $_POST['itemNameString'];
    $itemName = StringUtils::formatCase($itemNameString, StringUtils::FORMAT_LOWER_CAMEL_CASE);
    $subCategories = json_encode(explode(', ', $_POST['subCategories'])) ?? '';
    $baseColorOptions = json_encode(explode(', ', $_POST['baseColorOptions'])) ?? '';

    /* get file type for a specific file */
    $finfo = new finfo(FILEINFO_MIME);
    $mimeTypeString = $finfo->file($_FILES['image']['tmp_name']);
    finfo_close($finfo);
    preg_match('/\/[a-z]+;/', $mimeTypeString, $matches);
    $ext = substr($matches[0], 1, -1);

    $imgUrl = $itemName . '.' . $ext;
    $addActive = $_POST['addActive'] ?? '0';
    $addFeatured = $_POST['addFeatured'] ?? '0';

    //Check that the file was uploaded properly
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
      $uploadedFile = dirname(__FILE__, 2) . '/images/' . strtolower($_POST['mainCategory']) . '-original/' . $imgUrl;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
        //format image to the 3 needed sizes
        try {
          resizer($uploadedFile, dirname(__FILE__, 2) . '/images/' . strtolower($_POST['mainCategory']) . "-small/" . $imgUrl, [180, 200]);
          resizer($uploadedFile, dirname(__FILE__, 2) . '/images/' . strtolower($_POST['mainCategory']) . "-medium/" . $imgUrl, [720, 800]);
          resizer($uploadedFile, dirname(__FILE__, 2) . '/images/' . strtolower($_POST['mainCategory']) . "-large/" . $imgUrl, [1080, 1200]);
        } catch (Exception $err) {
          header("Location: ../admin-panel.php?addProduct=imageResizeError#add-form");
        }

        //Enter everything into the database
        $query =
          "INSERT INTO products (itemName, itemNameString, mainCategory, subCategories, price, shipping, baseColor, qtyInCart, imgUrl, dimensions, active, featured) VALUES (:itemName,:itemNameString,:mainCategory,:subCategories,:price,:shipping, :baseColorOptions,:qtyInCart,:imgUrl,:dimensions, :addActive, :addFeatured);";

        /* Values array for PDO */
        $values = array(':itemName' => $itemName, ':itemNameString' => $itemNameString, ':mainCategory' => $_POST['mainCategory'], ':subCategories' => $subCategories, ':price' => $_POST['price'], ':shipping' => $_POST['shipping'], 'baseColorOptions' => $baseColorOptions, ':qtyInCart' => 0, ':imgUrl' => $imgUrl, ':dimensions' => $_POST['dimensions'], ':addActive' => $addActive, ':addFeatured' => $addFeatured);

        // echo $_POST['itemNameString'] . '<br>';
        // echo $itemName . '<br>';
        // echo $_POST['mainCategory'] . '<br>';
        // echo print_r($subCategories) . '<br>';
        // echo $_POST['price'] . '<br>';
        // echo $_POST['shipping'] . '<br>';
        // echo $_POST['dimensions'] . '<br>';

        /* Execute the query */
        try {
          $res = $pdo->prepare($query);
          $res->execute($values);
          $retVal = $pdo->lastInsertId();

          header("Location: ../admin-panel.php?addProduct=success#add-form");

        } catch (PDOException $e) {
          $msg = $e->getMessage();
          header("Location: ../admin-panel.php?addProduct=query&code=" . $msg . "#add-form");
          exit();
        }
      }
    } else {
      // echo 'fail';
      header("Location: ../admin-panel.php?addProduct=imageError#add-form");
    }
  }
} else {
  header("Location: ../admin-panel.php?productMgmt=error");
  //TODO: make this error show on page
  exit();
}


function resizer($source, $destination, $size, $quality = null)
{
  // $source - Original image file
  // $destination - Resized image file name
  // $size - Single number for percentage resize
  // Array of 2 numbers for fixed width + height
  // $quality - Optional image quality. JPG & WEBP = 0 to 100, PNG = -1 to 9

  // (A) FILE CHECKS
  // Allowed image file extensions
  //   echo 'source: ' . $source . '<br>';
  $ext = strtolower(pathinfo($source)["extension"]);
  //   echo $ext;
  if (!in_array($ext, ["bmp", "gif", "jpg", "jpeg", "png", "webp"])) {
    throw new Exception("Invalid image file type");
  }

  // Source image not found!
  if (!file_exists($source)) {
    throw new Exception("Source image file not found");
  }

  // (B) IMAGE DIMENSIONS
  $dimensions = getimagesize($source);
  $width = $dimensions[0];
  $height = $dimensions[1];

  if (is_array($size)) {
    $new_width = $size[0];
    $new_height = $size[1];
  } else {
    $new_width = ceil(($size / 100) * $width);
    $new_height = ceil(($size / 100) * $height);
  }

  // (C) RESIZE
  // Respective PHP image functions
  $fnCreate = "imagecreatefrom" . ($ext == "jpg" ? "jpeg" : $ext);
  $fnOutput = "image" . ($ext == "jpg" ? "jpeg" : $ext);

  // Image objects
  $original = $fnCreate($source);
  $resized = imagecreatetruecolor($new_width, $new_height);

  // Transparent images only
  if ($ext == "png" || $ext == "gif") {
    imagealphablending($resized, false);
    imagesavealpha($resized, true);
    imagefilledrectangle(
      $resized,
      0,
      0,
      $new_width,
      $new_height,
      imagecolorallocatealpha($resized, 255, 255, 255, 127)
    );
  }

  // Copy & resize
  imagecopyresampled(
    $resized,
    $original,
    0,
    0,
    0,
    0,
    $new_width,
    $new_height,
    $width,
    $height
  );

  // (D) OUTPUT & CLEAN UP
  if (is_numeric($quality)) {
    $fnOutput($resized, $destination, $quality);
  } else {
    $fnOutput($resized, $destination);
  }
  imagedestroy($original);
  imagedestroy($resized);
}