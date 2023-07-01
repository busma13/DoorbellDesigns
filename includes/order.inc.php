<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/customer-class.inc.php';
require __DIR__ . '/order-class.inc.php';

include_once 'dbh.inc.php';

use Dotenv\Dotenv;
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\Order;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$client = new SquareClient([
    'accessToken' => $_ENV['SQUARE_ACCESS_TOKEN'],
    'environment' => $_ENV['ENVIRONMENT'],
]);

if (isset($_POST['submit'])) {

    $order = new DDOrder();
    $customer = new Customer();
    $customer->setFirst($_POST['first-name']);
    $customer->setLast($_POST['last-name']);
    $customer->setTel($_POST['tel']);
    $customer->setEmail($_POST['email']);
    $customer->setAddress_Line($_POST['address_line']);
    $customer->setCity($_POST['city']);
    $customer->setState($_POST['state']);
    $customer->setZip($_POST['zip']);

    $order->setCustomer($customer);

    // $first = $_POST['first-name'];
    // $last = $_POST['last-name'];
    // $tel = $_POST['tel'];
    // $email = $_POST['email'];
    // $address_line = $_POST['address-line'];
    // $city = $_POST['city'];
    // $state = $_POST['state'];
    // $zip = $_POST['zip'];
    $products = $_POST['cart-list-input'];

    if (empty($first) || empty($last) || empty($tel) || empty($email) || empty($address_line) || empty($city) || empty($state) || empty($zip) || empty($products)) {
        header("Location: ../checkout.php?order=empty#message");
        exit();
    } else {
        // Check for valid email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../checkout.php?order=email#message");
            exit();
        } else {
            //create unique ID for the order
            $id = uniqid('ID', true);

            $tel = formatTelephoneNumber($tel);

            // Create a payment link.  This includes an order object.
            $products_array = json_decode($_POST['cart-list-input'], false);

            $line_items = array();
            $TAX_RATE = 7.75; // get this from database call instead?
            $totalShippingCents = 0;
            $shippingQuantities = new stdClass;
            $shippingQuantities->doorbells5 = 0;
            $shippingQuantities->doorbells10 = 0;
            $shippingQuantities->fanPulls = 0;
            $shippingQuantities->airPlantCradles = 0;

            // add California tax if applicable
            if ($state === 'CA') {
                $order_line_item_tax = new \Square\Models\OrderLineItemTax();
                $order_line_item_tax->setName('State Sales Tax');
                $order_line_item_tax->setUid('state-sales-tax');
                $order_line_item_tax->setPercentage($TAX_RATE);
                $order_line_item_tax->setScope('LINE_ITEM');

                $taxes = [$order_line_item_tax];
            }

            $discounts = array();

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

                try {
                    $res1 = $pdo->prepare($get_products_sql);
                    $res1->execute();
                } catch (PDOException $e) {
                    header("Location: ../checkout.php?order=SQL-statement-failed#message");
                }
                while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
                    $priceArray = json_decode($row['priceArray']);
                    $priceCents = (int) $priceArray[0] * 100;

                    $shippingCents = $row['shipping'] * 100;
                    $mainCategory = $row['mainCategory'];

                    if ($mainCategory === 'Air-Plant-Cradles') {
                        $shippingQuantities->airPlantCradles += $obj->itemQty;
                    }
                    if ($mainCategory === 'Doorbells') {
                        if ($shippingCents == 1000) {
                            $shippingQuantities->doorbells10 += $obj->itemQty;
                        } else if ($shippingCents == 500) {
                            $shippingQuantities->doorbells5 += $obj->itemQty;
                        }
                    }
                    if ($mainCategory === 'Fan-Pulls') {
                        $shippingQuantities->fanPulls += $obj->itemQty;
                    }
                    // print_r($shippingQuantities);
                }

                $base_price_money = new \Square\Models\Money();
                $base_price_money->setAmount($priceCents);
                $base_price_money->setCurrency('USD');

                $order_line_item = new \Square\Models\OrderLineItem($obj->itemQty);

                if (count($priceArray) === 2) {
                    if ($obj->itemQty > 1) {
                        // echo 'i: ' . $i;
                        // echo '<br>';

                        $order_line_item_applied_discount = new \Square\Models\OrderLineItemAppliedDiscount($i);

                        $applied_discounts = [$order_line_item_applied_discount];

                        $order_line_item->setAppliedDiscounts($applied_discounts);

                        if ($obj->itemQty % 2 === 0) {
                            $dollarsOff = $obj->itemQty / 2 * 100;
                        } else {
                            $dollarsOff = ($obj->itemQty - 1) / 2 * 100;
                        }
                        // echo 'dollarsOff: ' . $dollarsOff;
                        // echo '<br>';

                        $amount_money = new \Square\Models\Money();
                        $amount_money->setAmount($dollarsOff);
                        $amount_money->setCurrency('USD');

                        $order_line_item_discount = new \Square\Models\OrderLineItemDiscount();
                        $order_line_item_discount->setUid($i);

                        // echo 'UID: ';
                        // echo $order_line_item_discount->getUid();
                        // echo '<br>';

                        $order_line_item_discount->setName('Fan pull pair discount');
                        $order_line_item_discount->setAmountMoney($amount_money);
                        $order_line_item_discount->setScope('LINE_ITEM');


                        $discounts[] = $order_line_item_discount;
                        // print_r($discounts);
                        // echo '<br>';
                    }
                }


                $itemNameWithOptions = setItemName($obj);
                $order_line_item->setName($itemNameWithOptions);
                $order_line_item->setBasePriceMoney($base_price_money);
                $order_line_item->setBasePriceMoney($base_price_money);

                $order_line_item_applied_tax = new \Square\Models\OrderLineItemAppliedTax('state-sales-tax');

                if ($state === 'CA') {
                    $applied_taxes = [$order_line_item_applied_tax];
                    $order_line_item->setAppliedTaxes($applied_taxes);
                }

                $line_items[] = $order_line_item;
            }

            // add shipping cost
            foreach ($shippingQuantities as $category => $qty) {
                if ($category == 'doorbells10') {
                    $totalShippingCents += 1000 * $qty;
                } else if ($category === 'doorbells5') {
                    // console.log(`${qtyAtEachShippingPrice[price]}`)
                    $totalShippingCents += 500 * $qty;
                } else if ($category === 'airPlantCradles') {
                    $totalShippingCents += 500 * $qty;
                } else if ($category === 'fanPulls') {
                    if ($qty > 0)
                        $totalShippingCents += 500;
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

            $checkout_options->setRedirectUrl($_ENV['REDIRECT_URL']); //TODO: change in env for production server

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
            $order = new Order($_ENV['SQUARE_LOCATION_ID']);

            $order->setLineItems($line_items);
            if ($state === 'CA') {
                $order->setTaxes($taxes);
            }
            $order->setFulfillments($fulfillments);
            $order->setDiscounts($discounts);
            // echo 'discounts: ';
            // echo count($discounts);
            $body = new \Square\Models\CreatePaymentLinkRequest();
            $body->setIdempotencyKey($id);
            $body->setOrder($order);
            $body->setCheckoutOptions($checkout_options);

            $api_response = $client->getCheckoutApi()->createPaymentLink($body);

            if ($api_response->isSuccess()) {
                $result = $api_response->getResult();
                $order_id = $result->getPaymentLink()->getOrderId();
                $payment_link_id = $result->getPaymentLink()->getId();

                // store order info in the orders database
                $insert_sql = "INSERT INTO orders (id, first_name, last_name, tel, email, address_line, city, state, zip, cart_products, order_id, paid) VALUES (:id, :first, :last, :tel, :email, :address_line, :city, :state, :zip, :products, :order_id, :paid);";

                /* Values array for PDO */
                $values = array(':id' => $id, ':first' => $first, ':last' => $last, ':tel' => $tel, ':email' => $email, ':address_line' => $address_line, ':city' => $city, ':state' => $state, ':zip' => $zip, ':products' => $products, ':order_id' => $order_id, ':paid' => 'no');
                /* Execute the query */
                try {
                    $res2 = $pdo->prepare($insert_sql);
                    $res2->execute($values);
                    $returnVal = $pdo->lastInsertId();
                } catch (PDOException $e) {
                    header("Location: ../checkout.php?order=SQL-statement-failed#message" . $returnVal); //work on this error on checkout.php
                }

                //Add the order id to the redirect url from Square to the confirmation page.
                $checkout_options = new \Square\Models\CheckoutOptions();

                $url = $_ENV['REDIRECT_URL'] . "?orderId=" . $order_id; //TODO: change for production server

                $checkout_options->setRedirectUrl($url);

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
                    sleep(5);
                    //Redirect user to square checkout page
                    header('Location: ' . $result->getPaymentLink()->getUrl());
                    exit();
                } else {
                    $errors = $api_response->getErrors();
                    $json = json_encode($errors);
                    exit($json);
                }
            } else {
                $errors = $api_response->getErrors();
                $json = json_encode($errors);
                exit($json);
            }
        }
    }
} else {
    header("Location: ../checkout.php?order=error#message");
    exit();
}

function formatTelephoneNumber($originalNumber)
{
    $number = str_replace('-', '', $originalNumber);
    $number = str_replace('(', '', $number);
    $number = str_replace(')', '', $number);
    $number = str_replace(' ', '', $number);
    if (strlen($number) === 10) {
        $number = "1" . $number;
    }
    return $number;
}

function setItemName($itemObj)
{
    $itemNameWithOptions = $itemObj->itemNameString;
    foreach ($itemObj->options->optionsPairStrings as $obj) {
        $itemNameWithOptions .= ', ' . $obj->stringKey . ' ' . $obj->stringValue;
    }
    return $itemNameWithOptions;
}