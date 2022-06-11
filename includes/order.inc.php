<?php
    include_once 'dbh.inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first-name']);
    $last = mysqli_real_escape_string($conn, $_POST['last-name']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address-line']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $products = mysqli_real_escape_string($conn, $_POST['cart-products']);

    $sql = "INSERT INTO orders (first_name, last_name, tel, email, address_line, city, zip, cart_products) VALUES ('$first', '$last', '$tel', '$email', '$address', '$city', '$zip', '$products');";

    mysqli_query($conn, $sql);

    header("Location: ../checkout.php?order=success"); // change to return link to square checkout page

