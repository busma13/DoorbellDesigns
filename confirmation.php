<?php
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

$transaction_id = $_GET["transactionId"];

//TODO: add transaction id and paid = yes to database

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
  echo print_r($_GET);
  echo 'Caught error';
  echo $err;
}

// If there was an error with the request we will
// print them to the browser screen here
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

    include 'header-pt1.php';
    $title = 'Checkout Confirmation - Doorbell Designs';
    echo $title;
    include 'header-pt2.php';
?>



    <div id="page-header" class="about">
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

  <div class="container" id="confirmation">
    <div>
      <div>
        <?php
        echo ("Order " . $order->getId());
        ?>
      </div>
      <div>
        <?php
        echo ("Status: " . $order->getState());
        ?>
      </div>
    </div>
    <div>
      <?php
      foreach ($order->getLineItems() as $line_item) {
        // Display each line item in the order, you may want to consider formatting the money amount using different currencies
        echo ("
          <div class=\"item-line\">
            <div class=\"item-label\">" . $line_item->getName() . " x " . $line_item->getQuantity() . "</div>
            <div class=\"item-amount\">$" . number_format((float)$line_item->getTotalMoney()->getAmount() / 100, 2, '.', '') . "</div>
          </div>");
      }

      // Display total amount paid for the order, you may want to consider formatting the money amount using different currencies
      echo ("
        <div>
          <div class=\"item-line total-line\">
            <div class=\"item-label\">Total</div>
            <div class=\"item-amount\">$" . number_format((float)$order->getTotalMoney()->getAmount() / 100, 2, '.', '') . "</div>
          </div>
        </div>
        ");
      ?>
    </div>
    <div>
      <span>Payment Successful!</span>
      <a href="http://localhost/doorbelldesigns">Back to home page</a>
    </div>
  </div>

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

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>