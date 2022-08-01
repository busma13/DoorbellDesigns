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



    <div id="page-header" class="complete">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Checkout Complete</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second"></p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<?php
$transaction_id = $_GET["transactionId"];

if ($transaction_id === null) { ?>
  <p class="whitespace noTransId">There was an error.  No transaction ID found.</p> 
<?php
}
else {
  try {
    $orders_api = $client->getOrdersApi();
    $response = $orders_api->retrieveOrder($transaction_id);
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
  if ($tenders) {
    $total_tenders = 0;
    for ($i = 0; $i < count($tenders); $i++) {
      $total_tenders += (int) $tenders[$i]->getAmountMoney()->getAmount();
    }
    if ($order->getTotalMoney()->getAmount() !== $total_tenders) { ?>
      <p class="whitespace notPaid">There was an error. There is still a balance due on this order.</p> 
      <?php
    }  
  }
  else {
    ?>
      <p class="whitespace notPaid">There was an error. No record of payment for this order.</p> 
      <?php
  }
  
?>

  <div class="container space-left space-right" id="confirmation">
    <div class="row">
      <h2>Thank you for your purchase!</h2>      
      <h4 class="space-top">Your Order:</h4>
      <?php

      foreach ($order->getLineItems() as $line_item) {
        // Display each line item in the order
        echo ("
          <div class=\"item-line\">
            <div class=\"item-label\">" . $line_item->getName() . " x " . $line_item->getQuantity() . "</div>
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
      <a href="http://localhost/doorbelldesigns">Back to home page</a>
    </div>
  </div>

  <?php
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

<!-- scrolling-nav -->
<script src="js/scrolling-nav.js"></script>
<!-- / scrolling-nav -->

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