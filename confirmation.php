<?php
include_once './includes/dbh.inc.php';
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Square\SquareClient;
use Square\Exceptions\ApiException;

// dotenv is used to read from the '.env' file created
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Use the environment and the key name to get the appropriate values from the .env file.
$access_token = $_ENV['SQUARE_ACCESS_TOKEN'];
$location_id = $_ENV['SQUARE_LOCATION_ID'];

// Initialize the authorization for Square
$client = new SquareClient([
  'accessToken' => $access_token,
  'environment' => $_ENV['ENVIRONMENT']
]);

include 'header-pt1.php';
$title = 'Checkout Confirmation - Doorbell Designs';
echo $title;
include 'header-pt2.php';
?>



    <div id="page-header" class="confirmation">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Checkout Complete</h1>
                </div><!-- / page-header -->
                <!-- <p class="slide-text fadeInUp animated second"></p> -->
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->
    <hr>
</header>
<!-- / header -->

<?php
$order_id = $_GET["orderId"];

if ($order_id === null) { 
?>
<div class="whitespace noTransId">
  <p>There was an error.  No order ID found.</p> 
  <p>Try reloading the page. If you still need help get in contact <a href="/doorbelldesigns/contact.php">here</a>.</p> 
</div>
  
  <div class="space-top text-center">
    <a href="index.php">Back to home page</a>
  </div>
<?php
}
else {
  try {
    $orders_api = $client->getOrdersApi();
    $response = $orders_api->retrieveOrder($order_id);
  } catch (ApiException $e) {
    // If an error occurs, output the message
    echo 'Caught exception!<br/>';
    echo '<strong>Response body:</strong><br/>';
    echo '<pre>';
    var_dump($e->getHttpResponse());
    echo '</pre>';
    // echo '<br/><strong>Context:</strong><br/>';
    // echo '<pre>';
    // var_dump($e->getContext());
    // echo '</pre>';
    exit();
  } catch (Error $err) {
    echo 'Caught error';
    echo $err;
    exit();
  }
  
  // If there was an error with the request we will
  // print it to the browser screen here
  if ($response->isError()) {
    echo 'Api response has Errors';
    $errors = $response->getErrors();
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>❌ ' . $error->getDetail() . '</li>';
    }
    echo '</ul>';
    exit();
  } else {
    $order = $response->getResult()->getOrder();
  }

  // Check that order has been paid for.
  $tenders = $order->getTenders();
  if (!$tenders) {
?>
      <div class="whitespace noTransId">
        <p>There was an error.  No record of payment for this order.</p> 
        <p>Try reloading the page. If you still need help get in contact <a href="/doorbelldesigns/contact.php">here</a>.</p> 
      </div>
      <div class="space-top text-center">
          <a href="index.php">Back to home page</a>
      </div>
<?php      
  }
  else {
    $total_tenders = 0;
    for ($i = 0; $i < count($tenders); $i++) {
      $total_tenders += (int) $tenders[$i]->getAmountMoney()->getAmount();
    }
    if ($order->getTotalMoney()->getAmount() !== $total_tenders) { 
?>
      <div class="whitespace noTransId">
        <p>There was an error.  There is still a balance due on this order.</p> 
        <p>Try reloading the page. If you still need help get in contact <a href="/doorbelldesigns/contact.php">here</a>.</p> 
      </div>

      <div class="space-top text-center">
          <a href="index.php">Back to home page</a>
      </div>
<?php
    }
    else { 
      //Set the order status to paid in the database
      $query = "UPDATE orders SET paid = :paid
                WHERE order_id = :order_id;"; 
      
      $values = array(':paid' => 'yes', ':order_id' => $order_id);

      /* Execute the query */
      try
      {
          $res = $pdo->prepare($query);
          $success = $res->execute($values);
          $response = $pdo->lastInsertId();
      }
      catch (PDOException $e)
      {
          $msg = $e->getMessage();
          $response = $msg . ' ' . $query;
      }     
?>
      <div class="container space-left space-right" id="confirmation">
        <div class="row">
          <h2 class="space-top">Thank you for your purchase!</h2>      
          <h4 class="space-top">Your Order:</h4>
<?php
          foreach ($order->getLineItems() as $line_item) {
            // Display each line item in the order
            echo ("
              <div class=\"item-line\">
                <div class=\"item-label\"> (" . $line_item->getQuantity() . ") " . $line_item->getName() . "</div>
                <div class=\"item-amount\">$" . number_format((float)$line_item->getTotalMoney()->getAmount() / 100, 2, '.', '') . "</div>
              </div>");
          }

          // Display total amount paid for the order
          echo ("
            <div>
              <div class=\"item-line total-line\">
                <div class=\"item-label\">Total</div>
                <div class=\"item-amount\">$" . number_format((float)$order->getTotalMoney()->getAmount() / 100, 2, '.', '') . "</div>
              </div>
            </div>
            ");
?>
        </div class="row">
        <h4 class="space-top">Payment Successful!</h4>
        <div>
          <div class="space-top">
            <?php
            echo ("Square Order Id: " . $order->getId());
            ?>
          </div>
        </div>
        <div class="space-top">
          <a href="index.php">Back to home page</a>
        </div>
      </div>
<?php
    }  
  }
}
?>

  <!-- footer -->
<?php
    include 'footer.php';
?>
  <!-- / footer -->

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- shuffle grid-resizer -->
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/custom.js"></script>
<!-- / shuffle grid-resizer -->

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>