<?php 

$base_price_money = new \Square\Models\Money();
$base_price_money->setAmount(1500);
$base_price_money->setCurrency('USD');

$order_line_item_applied_discount = new \Square\Models\OrderLineItemAppliedDiscount('one-dollar-off');

$applied_discounts = [$order_line_item_applied_discount];

$order_line_item = new \Square\Models\OrderLineItem('1');
$order_line_item->setName('Fan Pull');
$order_line_item->setBasePriceMoney($base_price_money);
$order_line_item->setAppliedDiscounts($applied_discounts);

// $order_line_item_modifier = new \Square\Models\OrderLineItemModifier();
// $order_line_item_modifier->setCatalogObjectId('CHQX7Y4KY6N5KINJKZCFURPZ');

// $modifiers = [$order_line_item_modifier];

// $order_line_item1 = new \Square\Models\OrderLineItem('2');
// $order_line_item1->setCatalogObjectId('BEMYCSMIJL46OCDV4KYIKXIB');
// $order_line_item1->setModifiers($modifiers);

$line_items = [$order_line_item];

$amount_money = new \Square\Models\Money();
$amount_money->setAmount(100);
$amount_money->setCurrency('USD');

$order_line_item_discount = new \Square\Models\OrderLineItemDiscount();
$order_line_item_discount->setUid('one-dollar-off');
$order_line_item_discount->setName('Fan pull pair discount');
$order_line_item_discount->setAmountMoney($amount_money);
$order_line_item_discount->setScope('LINE_ITEM');

$discounts = [
    $order_line_item_discount
];
$order = new \Square\Models\Order('057P5VYJ4A5X1');
$order->setReferenceId('my-order-001');
$order->setLineItems($line_items);
$order->setTaxes($taxes);
$order->setDiscounts($discounts);

$body = new \Square\Models\CreateOrderRequest();
$body->setOrder($order);
$body->setIdempotencyKey('8193148c-9586-11e6-99f9-28cfe92138cf');

$api_response = $client->getOrdersApi()->createOrder($body);

if ($api_response->isSuccess()) {
    $result = $api_response->getResult();
} else {
    $errors = $api_response->getErrors();
}