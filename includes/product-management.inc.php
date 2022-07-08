<?php
include_once 'dbh.inc.php';
require '../turbocommons-php-3.8.0.phar';
use org\turbocommons\src\main\php\utils\StringUtils;

if (isset($_POST['addProduct'])) {

    if (empty($_POST['itemNameString']) || empty($_POST['mainCategory']) || empty($_POST['price']) || empty($_POST['shipping']) || empty($_POST['dimensions']) || empty($_POST['subCategories']) || empty($_POST['image'])) {
        header("Location: ../admin-panel.php?addProduct=empty#add-form");
        exit();
    }
    else {
        $itemNameString = $_POST['itemNameString'];
        $itemName = StringUtils::formatCase($itemNameString, StringUtils::FORMAT_LOWER_CAMEL_CASE);
        $subCategories = json_encode(explode(' ', $_POST['subCategories']));
        $imgUrl = 'images/' . strtolower($_POST['mainCategory']) . '/' . $itemName . '.jpg';

        //TODO format image and store to images folder
        
        $query =         
        "INSERT INTO products (itemName, itemNameString, mainCategory, subCategories, price, shipping, qtyInCart, imgUrl, dimensions) VALUES (:itemName,:itemNameString,:mainCategory,:subCategories,:price,:shipping,:qtyInCart,:imgUrl,:dimensions);";
        
        /* Values array for PDO */
        $values = array(':itemName' => $itemName, ':itemNameString' => $itemNameString,':mainCategory' => $_POST['mainCategory'],':subCategories' => $subCategories,':price' => $_POST['price'],':shipping' => $_POST['shipping'],':qtyInCart' => 0,':imgUrl' => $imgUrl,':dimensions' => $_POST['dimensions']);
    
        echo $_POST['itemNameString'] . '<br>';
        echo $itemName . '<br>';
        echo $_POST['mainCategory'] . '<br>';
        echo print_r($subCategories) . '<br>';
        echo $_POST['price'] . '<br>';
        echo $_POST['shipping'] . '<br>';
        echo $_POST['dimensions'] . '<br>';
        
        /* Execute the query */
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
            $retVal = $pdo->lastInsertId();
            echo $retVal;
            header("Location: ../admin-panel.php?addProduct=success#add-form");
        }
        catch (PDOException $e)
        {
            $msg = $e->getMessage();
            header("Location: ../admin-panel.php?addProduct=query&code=" . $msg . "#add-form");
            exit();
        }
        
    } 
    
}
else {
    header("Location: ../admin-panel.php?addProduct=error#add-form");
    exit();
}
