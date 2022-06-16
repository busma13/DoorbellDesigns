<?php


require '../vendor/autoload.php'; 

use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\Order;

// echo getenv('SQUARE_ACCESS_TOKEN');

$client = new SquareClient([
    'accessToken' => getenv('SQUARE_ACCESS_TOKEN') , //update for production
    'environment' => getenv('ENVIRONMENT'), // update for production
    // 'accessToken' => 'EAAAEFN_O2W7e2OFxMrK-kO7VE37kDXLCsZdU5m8emAZa_opNfCoINMcbFqK1maV' , //update for production
    // 'environment' => 'sandbox', // update for production
]);

if (isset($_POST['submit'])) {

    include_once 'dbh.inc.php';

    $first = mysqli_real_escape_string($conn, $_POST['first-name']);
    $last = mysqli_real_escape_string($conn, $_POST['last-name']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address_line = mysqli_real_escape_string($conn, $_POST['address-line']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $products = mysqli_real_escape_string($conn, $_POST['cart-products']);

    if (empty($first) || empty($last) || empty($email) || empty($address_line) || empty($city) || empty($state) || empty($zip) || empty($products)) {
        header("Location: ../checkout.php?order=empty");
        exit();
    }
    else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../checkout.php?order=email");
            exit();
        }
        else {
            //create unique ID for the order
            $id = uniqid('ID', true);
            // store order info in the orders database
            $sql = "INSERT INTO orders (id, first_name, last_name, tel, email, address_line, city, state, zip, cart_products) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../checkout.php?order=SQL-statement-failed");//work on this
            } else {
                mysqli_stmt_bind_param($stmt, "ssssssssss", $id, $first, $last, $tel, $email, $address_line, $city, $state, $zip, $products);
                mysqli_stmt_execute($stmt);
            }

            // Create a payment link.  This includes an order object.
            $post_array = array($id, $first, $last, $tel, $email, $address_line, $city, $state, $zip, $products);
            
            // try {
            //     $payment_link_url = createPaymentLink($client, $post_data); // check if response is a url or an error.
            //     header("Location: " . $payment_link_url); // change to return link to square checkout page
            // }
            // catch (Exception $ex) {
            //     $exception = $ex->getMessage();
            //     header("Location: ./checkout.php?ex=" . $exception);
            // }
            // exit();
            $base_price_money = new \Square\Models\Money();
            $base_price_money->setAmount(5500);//fill
            $base_price_money->setCurrency('USD');
            
            $base_price_money1 = new \Square\Models\Money();
            $base_price_money1->setAmount(4300);//fill
            $base_price_money1->setCurrency('USD');
            
            $base_price_money2 = new \Square\Models\Money();
            $base_price_money2->setAmount(750);//fill
            $base_price_money2->setCurrency('USD');
            
            $order_line_item = new \Square\Models\OrderLineItem('1');//fill
            $order_line_item->setName('Paws Doorbell');//fill
            $order_line_item->setBasePriceMoney($base_price_money);
            
            $order_line_item1 = new \Square\Models\OrderLineItem('1');//fill
            $order_line_item1->setName('Bamboo Doorbell');//fill
            $order_line_item1->setBasePriceMoney($base_price_money1);
            
            $order_line_item2 = new \Square\Models\OrderLineItem('1');//fill
            $order_line_item2->setName('shipping');//fill
            $order_line_item2->setBasePriceMoney($base_price_money2);
            
            $line_items = [$order_line_item, $order_line_item1, $order_line_item2];
            
            $checkout_options = new \Square\Models\CheckoutOptions();
            $checkout_options->setAskForShippingAddress(true);
            $checkout_options->setRedirectUrl("http://localhost/doorbelldesigns/confirmation.php"); //add this or use square's confirmation page?
            
            $address = new \Square\Models\Address();
            $address->setAddressLine1($post_array[5]);
            $address->setLocality($post_array[6]);
            $address->setAdministrativeDistrictLevel1($post_array[7]);
            $address->setPostalCode($post_array[8]);
            $address->setCountry('US');
            
            $recipient = new \Square\Models\OrderFulfillmentRecipient();
            $recipient->setDisplayName($post_array[1] . ' ' . $post_array[2]);
            $recipient->setPhoneNumber($post_array[3]);
            $recipient->setEmailAddress($post_array[4]);
            $recipient->setAddress($address);
            
            $pre_populated_data = new \Square\Models\PrePopulatedData();
            // $pre_populated_data->setBuyerAddress($address);//here
            // $pre_populated_data->setBuyerEmail($recipient->getEmailAddress);
            $pre_populated_data->setBuyerPhoneNumber($post_array[3]);
            
            $shipment_details = new \Square\Models\OrderFulfillmentShipmentDetails();
            $shipment_details->setRecipient($recipient);
            
            $order_fulfillment = new \Square\Models\OrderFulfillment();
            $order_fulfillment->setType('SHIPMENT');
            $order_fulfillment->setShipmentDetails($shipment_details);
            
            $fulfillments = [$order_fulfillment];
            $order = new Order('L20MQK5M4PT2Z'); //location - change from sandbox to real location
            // $order->setCustomerId($post_array[9]); //remove if not needed. If needed add ID to array after received from database.
            $order->setLineItems($line_items);
            $order->setFulfillments($fulfillments);
            
            $body = new \Square\Models\CreatePaymentLinkRequest();
            $body->setIdempotencyKey($post_array[0]); 
            $body->setOrder($order);
            $body->setCheckoutOptions($checkout_options);
            $body->setPrePopulatedData($pre_populated_data);
            
            //checkoutAPI
            $api_response = $client->getCheckoutApi()->createPaymentLink($body);
            
            if ($api_response->isSuccess()) {
                $result = $api_response->getResult();
                
                $payment_link = json_encode($result->getPaymentLink()->getUrl());
                $payment_link =  stripslashes($payment_link);
                // return $payment_link;
                // exit($payment_link);//Access-Control-Allow-Origin: 
                header('Location: '.$result->getPaymentLink()->getUrl()); // change to return link to square checkout page
                exit();
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

// Create payment link request that includes Order object
function createPaymentLink($client, $post_array) {

    // for ($i = 0; $i < $post_array[8]; $i++) {

    // }
    $base_price_money = new \Square\Models\Money();
    $base_price_money->setAmount(5500);//fill
    $base_price_money->setCurrency('USD');
    
    $base_price_money1 = new \Square\Models\Money();
    $base_price_money1->setAmount(4300);//fill
    $base_price_money1->setCurrency('USD');
    
    $base_price_money2 = new \Square\Models\Money();
    $base_price_money2->setAmount(750);//fill
    $base_price_money2->setCurrency('USD');
    
    $order_line_item = new \Square\Models\OrderLineItem('1');//fill
    $order_line_item->setName('Paws Doorbell');//fill
    $order_line_item->setBasePriceMoney($base_price_money);
    
    $order_line_item1 = new \Square\Models\OrderLineItem('1');//fill
    $order_line_item1->setName('Bamboo Doorbell');//fill
    $order_line_item1->setBasePriceMoney($base_price_money1);
    
    $order_line_item2 = new \Square\Models\OrderLineItem('1');//fill
    $order_line_item2->setName('shipping');//fill
    $order_line_item2->setBasePriceMoney($base_price_money2);
    
    $line_items = [$order_line_item, $order_line_item1, $order_line_item2];
    
    $checkout_options = new \Square\Models\CheckoutOptions();
    $checkout_options->setAskForShippingAddress(true);
    
    $address = new \Square\Models\Address();
    $address->setAddressLine1($post_array[5]);
    $address->setLocality($post_array[6]);
    $address->setAdministrativeDistrictLevel1($post_array[7]);
    $address->setPostalCode($post_array[8]);
    $address->setCountry('US');
    
    $recipient = new \Square\Models\OrderFulfillmentRecipient();
    $recipient->setDisplayName($post_array[1] . ' ' . $post_array[2]);
    $recipient->setPhoneNumber($post_array[3]);
    $recipient->setEmailAddress($post_array[4]);
    $recipient->setAddress($address);
    
    // $pre_populated_data = new \Square\Models\PrePopulatedData();
    // $pre_populated_data->setBuyerAddress($address);//here
    // $pre_populated_data->setBuyerEmail($recipient->getEmailAddress);
    // $pre_populated_data->setBuyerPhoneNumber($recipient->getPhoneNumber);
    
    $shipment_details = new \Square\Models\OrderFulfillmentShipmentDetails();
    $shipment_details->setRecipient($recipient);
    
    $order_fulfillment = new \Square\Models\OrderFulfillment();
    $order_fulfillment->setType('SHIPMENT');
    $order_fulfillment->setShipmentDetails($shipment_details);
    
    $fulfillments = [$order_fulfillment];
    $order = new Order('L20MQK5M4PT2Z'); //location - change from sandbox to real location
    // $order->setCustomerId($post_array[9]); //remove if not needed. If needed add ID to array after received from database.
    $order->setLineItems($line_items);
    $order->setFulfillments($fulfillments);//here
    
    $body = new \Square\Models\CreatePaymentLinkRequest();
    $body->setIdempotencyKey($post_array[0]); 
    $body->setOrder($order);
    $body->setCheckoutOptions($checkout_options);
    // $body->setPrePopulatedData($pre_populated_data);
    
    //checkoutAPI
    $api_response = $client->getCheckoutApi()->createPaymentLink($body);
    
    if ($api_response->isSuccess()) {
        $result = $api_response->getResult();
        
        $payment_link = json_encode($result->getPaymentLink()->getUrl());
        $payment_link =  stripslashes($payment_link);
        return $payment_link;
    } else {
        $errors = $api_response->getErrors();
        $json = json_encode($errors);
        return $json;
    }
}


