<?php

if (isset($_POST['submit'])) {

    include_once 'dbh.inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first-name']);
    $last = mysqli_real_escape_string($conn, $_POST['last-name']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address-line']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $products = mysqli_real_escape_string($conn, $_POST['cart-products']);

    if (empty($first) || empty($last) || empty($email) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($products)) {
        header("Location: ../checkout.php?order=empty");
        exit();
    }
    else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../checkout.php?order=email");
            exit();
        }
        else {
            // store order info in the orders database
            $sql = "INSERT INTO orders (first_name, last_name, tel, email, address_line, city, state, zip, cart_products) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
            } else {
                mysqli_stmt_bind_param($stmt, "sssssssss",  $first, $last, $tel, $email, $address, $city, $state, $zip, $products);
                mysqli_stmt_execute($stmt);
            }

            // create a square order object
        
            header("Location: ../checkout.php?order=success"); // change to return link to square checkout page
            exit();
        }
    }
}
else {
    header("Location: ../checkout.php?order=error");
    exit();
}



