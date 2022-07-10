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
    
        // echo $_POST['itemNameString'] . '<br>';
        // echo $itemName . '<br>';
        // echo $_POST['mainCategory'] . '<br>';
        // echo print_r($subCategories) . '<br>';
        // echo $_POST['price'] . '<br>';
        // echo $_POST['shipping'] . '<br>';
        // echo $_POST['dimensions'] . '<br>';
        
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
else if (isset($_POST['deleteProduct'])) {
    if (!isset($_POST['deleteProductName'])) {
        header("Location: ../admin-panel.php?deleteProduct=empty#delete-form");
        exit();    
    }
    $deleteProductName = StringUtils::formatCase($_POST['deleteProductName'], StringUtils::FORMAT_LOWER_CAMEL_CASE);
    echo $deleteProductName;

    $query = "DELETE FROM `products` WHERE itemName = :deleteProductName;";

    /* Execute the query */
    try
    {
        $res = $pdo->prepare($query);
        $res->bindParam(':deleteProductName', $deleteProductName);
        $success = $res->execute();
        if ($success) {
            header("Location: ../admin-panel.php?deleteProduct=success#delete-form");

        }
        else {
            header("Location: ../admin-panel.php?deleteProduct=fail#delete-form");
        }
    }
    catch (PDOException $e)
    {
        $msg = $e->getMessage();
        echo $msg;
        header("Location: ../admin-panel.php?deleteProduct=query&code=" . $msg . "#delete-form");
        exit();
    }
}
else if (isset($_POST['editProduct'])) {
    echo 'edit prod man' . '<br>';
    if (empty($_POST['newNameString']) || empty($_POST['mainCategory']) || empty($_POST['price']) || empty($_POST['shipping']) || empty($_POST['dimensions']) || empty($_POST['subCategories']) || empty($_POST['image'])) {
        header("Location: ../admin-panel.php?editProduct=empty#edit-form");   
    } 
    else {
        echo 'else' . '<br>';
        $itemName = StringUtils::formatCase($_POST['newNameString'], StringUtils::FORMAT_LOWER_CAMEL_CASE);
        $subCategories = json_encode(explode(' ', $_POST['subCategories']));
        $imgUrl = 'images/' . strtolower($_POST['mainCategory']) . '/' . $itemName . '.jpg';

        //TODO format image and store to images folder
        
        $query =         
        "INSERT INTO products (itemName, newNameString, mainCategory, subCategories, price, shipping, qtyInCart, imgUrl, dimensions) VALUES (:itemName,:newNameString,:mainCategory,:subCategories,:price,:shipping,:qtyInCart,:imgUrl,:dimensions);";
        
        /* Values array for PDO */
        $values = array(':itemName' => $itemName, ':newNameString' => $_POST['newNameString'],':mainCategory' => $_POST['mainCategory'],':subCategories' => $subCategories,':price' => $_POST['price'],':shipping' => $_POST['shipping'],':qtyInCart' => 0,':imgUrl' => $imgUrl,':dimensions' => $_POST['dimensions']);
        
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
