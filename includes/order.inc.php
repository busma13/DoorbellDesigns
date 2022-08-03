<?php

require '../vendor/autoload.php'; 
include_once 'dbh.inc.php';

use Dotenv\Dotenv;
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\Order;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$client = new SquareClient([
    'accessToken' => $_ENV['SQUARE_ACCESS_TOKEN'] , //update for production
    'environment' => $_ENV['ENVIRONMENT'], // update for production
]);

if (isset($_POST['submit'])) {

    $first = $_POST['first-name'];
    $last = $_POST['last-name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address_line = $_POST['address-line'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $products = $_POST['cart-list-input'];

    if (empty($first) || empty($last) || empty($tel) || empty($email) || empty($address_line) || empty($city) || empty($state) || empty($zip) || empty($products)) {
        header("Location: ../checkout.php?order=empty");
        exit();
    }
    else {
        // Check for valid email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../checkout.php?order=email");
            exit();
        }
        else {
            //create unique ID for the order
            $id = uniqid('ID', true);

            if (strlen($tel) === 10) {
                $tel = "1" . $tel;
            }

            // Create a payment link.  This includes an order object.
            $products_array = json_decode($_POST['cart-list-input'], false);
            
            $line_items = array();
            $TAX_RATE = 7.75; // get this from database?
            $totalShippingCents = 0;
            $qtyAtEachShippingPrice = new stdClass;

             // add California tax if applicable
             if ($state === 'CA') {
                $order_line_item_tax = new \Square\Models\OrderLineItemTax();
                $order_line_item_tax->setName('State Sales Tax');
                $order_line_item_tax->setUid('state-sales-tax');
                $order_line_item_tax->setPercentage($TAX_RATE);
                $order_line_item_tax->setScope('LINE_ITEM');//????

                $taxes = [$order_line_item_tax];
            }

            for ($i = 0; $i < count($products_array); $i++) {
                $priceCents = 0;
                $obj = $products_array[$i];
                // echo var_dump($obj);
                // echo '<br>';
                // echo $obj->itemName;
                // echo '<br>';
                // echo $obj->itemQty;
                // echo '<br>';

                $prodId = $obj->id;
                $get_products_sql = "SELECT * FROM products WHERE id=$prodId;";
                // $queryResult = mysqli_query($conn, $get_products_sql);
                // $resultCheck = mysqli_num_rows($queryResult);

                /* Execute the query */
                try
                {
                    $res2 = $pdo->prepare($get_products_sql);
                    $res2->execute();
                }
                catch (PDOException $e)
                {
                    header("Location: ../checkout.php?order=SQL-statement-failed");
                }
                while ($row = $res2->fetch(PDO::FETCH_ASSOC)) { 

                // if ($resultCheck > 0) {
                //     while ($row = mysqli_fetch_assoc($queryResult)) {
                        $priceCents = $row['price'] * 100;
                        $shippingCents = $row['shipping'] * 100;
                        // echo $priceCents;
                        // echo '<br>';
                        // echo$shippingCents;
                        // echo '<br>';

                        if (!$qtyAtEachShippingPrice->$shippingCents) {
                            $qtyAtEachShippingPrice->$shippingCents = $obj->itemQty;
                        } else {
                            $qtyAtEachShippingPrice->$shippingCents += $obj->itemQty;
                        }
                    
                }

                $base_price_money = new \Square\Models\Money();
                $base_price_money->setAmount($priceCents);
                $base_price_money->setCurrency('USD');

                $order_line_item = new \Square\Models\OrderLineItem($obj->itemQty);
                $order_line_item->setName($obj->itemNameString . ", " . $obj->baseColor . " Base");
                $order_line_item->setBasePriceMoney($base_price_money);

                $order_line_item_applied_tax = new \Square\Models\OrderLineItemAppliedTax('state-sales-tax');

                if ($state === 'CA') {
                    $applied_taxes = [$order_line_item_applied_tax];
                    $order_line_item->setAppliedTaxes($applied_taxes);
                }

                $line_items[] = $order_line_item;
            }

            // add shipping cost

            // print_r($qtyAtEachShippingPrice);

            foreach ($qtyAtEachShippingPrice as $price => $qty) {
                // echo "$price => $qty <br>";
                if ($price == 350) {
                    if($qty % 2 === 0) {
                        $totalShippingCents += $price * $qty / 2;
                        // echo $totalShippingCents . '<br>';
                    } else {
                        $totalShippingCents += $price * ($qty + 1) / 2;
                        // echo $totalShippingCents . '<br>';
                    }
                } else {
                    $totalShippingCents += $price * $qty; // fix for other shipping prices
                    // echo $totalShippingCents . '<br>';
                }
            }
            
            $shipping_money = new \Square\Models\Money();
            $shipping_money->setAmount($totalShippingCents);
            $shipping_money->setCurrency('USD');

            $order_line_item_shipping = new \Square\Models\OrderLineItem('1');
            $order_line_item_shipping->setName('Shipping');
            $order_line_item_shipping->setBasePriceMoney($shipping_money);
            $line_items[] = $order_line_item_shipping;
            
            $checkout_options = new \Square\Models\CheckoutOptions();
            $host = $_SERVER['HTTP_HOST'];
            if ($host === 'localhost') {
                $checkout_options->setRedirectUrl("http://localhost/doorbelldesigns/confirmation.php");
            } 
            else {
                $checkout_options->setRedirectUrl("http://doorbelldesigns.herokuapp.com/confirmation.php"); //change for production server
            }
            
            $address = new \Square\Models\Address();
            $address->setAddressLine1($address_line);
            $address->setLocality($city);
            $address->setAdministrativeDistrictLevel1($state);
            $address->setPostalCode($zip);
            $address->setCountry('US');
            
            $recipient = new \Square\Models\OrderFulfillmentRecipient();
            $recipient->setDisplayName($first . ' ' . $last);
            $recipient->setPhoneNumber($tel);
            $recipient->setEmailAddress($email);
            $recipient->setAddress($address);
            
            $shipment_details = new \Square\Models\OrderFulfillmentShipmentDetails();
            $shipment_details->setRecipient($recipient);
            
            $order_fulfillment = new \Square\Models\OrderFulfillment();
            $order_fulfillment->setType('SHIPMENT');
            $order_fulfillment->setShipmentDetails($shipment_details);
            
            $fulfillments = [$order_fulfillment];
            $order = new Order('L20MQK5M4PT2Z'); //location - change from sandbox to real location
            
            $order->setLineItems($line_items);
            $order->setTaxes($taxes);
            $order->setFulfillments($fulfillments);
            
            $body = new \Square\Models\CreatePaymentLinkRequest();
            $body->setIdempotencyKey($id); 
            $body->setOrder($order);
            $body->setCheckoutOptions($checkout_options);
            
            // checkoutAPI
            $api_response = $client->getCheckoutApi()->createPaymentLink($body);
            
            if ($api_response->isSuccess()) {
                $result = $api_response->getResult();
                $order_id = $result->getPaymentLink()->getOrderId();
                $payment_link_id = $result->getPaymentLink()->getId();
                // echo $result->getPaymentLink()->getCheckoutOptions();
                $payment_link = json_encode($result->getPaymentLink()->getUrl());
                $payment_link =  stripslashes($payment_link);

                

                // store order info in the orders database
                $insert_sql = "INSERT INTO orders (id, first_name, last_name, tel, email, address_line, city, state, zip, cart_products, order_id, paid) VALUES (:id, :first, :last, :tel, :email, :address_line, :city, :state, :zip, :products, :order_id, :paid);";
                
                /* Values array for PDO */
                $values = array(':id' => $id, ':first' => $first, ':last' => $last, ':tel' => $tel, ':email' => $email, ':address_line' => $address_line, ':city' => $city, ':state' => $state, ':zip' => $zip, ':products' => $products, ':order_id' => $order_id, ':paid' => 'no');
                
                /* Execute the query */
                try
                {
                    $res = $pdo->prepare($insert_sql);
                    $res->execute($values);
                    $retVal = $pdo->lastInsertId();
                }
                catch (PDOException $e)
                {
                    header("Location: ../checkout.php?order=SQL-statement-failed");//work on this error on checkout.php
                }

                // //Add the order id to the redirect url from Square to the confirmation page.
                $checkout_options = new \Square\Models\CheckoutOptions();
                $host = $_SERVER['HTTP_HOST'];
                $url = '1';
                if ($host === 'localhost') {
                    $url = "http://localhost/doorbelldesigns/confirmation.php?orderId=" . $order_id;
                    $checkout_options->setRedirectUrl($url);
                } 
                else {
                    $url = "http://doorbelldesigns.herokuapp.com/confirmation.php?orderId=" . $order_id;
                    $checkout_options->setRedirectUrl($url); //change for production server
                }
                
                $payment_link = new \Square\Models\PaymentLink(1);
                $payment_link->setCheckoutOptions($checkout_options);
                
                $body = new \Square\Models\UpdatePaymentLinkRequest($payment_link);
                // checkoutAPI
                $api_response = $client->getCheckoutApi()->updatePaymentLink($payment_link_id, $body);

                if ($api_response->isSuccess()) {
                    $result = $api_response->getResult();
                    $payment_link = json_encode($result->getPaymentLink()->getUrl());
                    // $payment_link =  stripslashes($payment_link);
                    // echo $payment_link;
                    
                    /* This delay ensures the payment link will be created by square before the user is redirected to it.
                    */
                    // sleep(1);
                    //Redirect user to square checkout page
                    header('Location: '.$result->getPaymentLink()->getUrl());
                exit();
                } else {
                    $errors = $api_response->getErrors();
                    $json = json_encode($errors);
                    exit($json);
                    // header("Location: ./checkout.php?ex=" . $exception);
                }
            } else {
                $errors = $api_response->getErrors();
                $json = json_encode($errors);
                exit($json);
                // header("Location: ./checkout.php?ex=" . $exception);
            }
        }
    }
}
else {
    header("Location: ../checkout.php?order=error");
    exit();
}