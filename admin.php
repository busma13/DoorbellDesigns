<?php
session_start();
include_once './src/Dbh.php';
use App\AccountClass;

$account = new AccountClass();
include 'header-pt1.php';
$title = 'Doorbell Designs Admin - Login';
echo $title;
include 'header-pt2.php';
?>

<div id="page-header" class="checkout">
  <div class="container">
    <div class="page-header-content text-center">
      <div class="page-header wsub">
        <h1 class="page-title fadeInDown animated first">Admin Login</h1>
      </div><!-- / page-header -->
      <p>
        <img sizes="(max-width: 1400px) 98vw, 1400px"
          srcset="https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_200/v1676250824/banner/banner_ni12ho.jpg 200w,

                    https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_653/v1676250824/banner/banner_ni12ho.jpg 653w,

                    https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_981/v1676250824/banner/banner_ni12ho.jpg 981w,

                    https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_1207/v1676250824/banner/banner_ni12ho.jpg 1207w,

                    https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_1400/v1676250824/banner/banner_ni12ho.jpg 1400w"
          src="https://res.cloudinary.com/doorbelldesigns/image/upload/f_auto/q_auto/c_scale/w_1400/v1676250824/banner/banner_ni12ho.jpg"
          alt="Doorbell banner" />
      </p>
    </div><!-- / page-header-content -->
  </div><!-- / container -->
</div><!-- / page-header -->
<hr>
</header>
<!-- / header -->

<?php
$login = FALSE;

try {
  $login = $account->sessionLogin();
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

if ($login) { ?>

  <div class="log-in flex space-top-2x space-bottom-2x">
    <p class="space-top text-center">You are logged in as: <?php echo $account->getName() ?></p>
    <div class="space-top flex logged-in">
      <a href="./admin-panel.php" class="btn btn-primary-filled btn-rounded"><span>Go To Admin Panel</span></a>

      <form action="./src/AdminLogin.php" method="POST">
        <button type="submit" name="logout" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log out</button>
      </form>
    </div>
  </div>
  <?php
} else {

  ?>

  <!-- content -->

  <form action="./src/AdminLogin.php" method="POST" class="log-in flex space-top-2x space-bottom-2x">
    <fieldset class="space-top">
      <label for="userName">User name:</label>
      <input type="text" name="userName" placeholder="User name" id="userName">
    </fieldset>
    <fieldset class="space-top space-bottom">
      <label for="password">Password:</label>
      <input type="password" name="password" placeholder="Password" id="password">
    </fieldset>
    <button type="submit" name="login" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log in</button>

  </form>

  <div>
    <!-- Server side form validation notifications. -->
    <?php
    if (!isset($_GET['login'])) {
      //do nothing
    } else {
      $loginError = $_GET['login'];

      if ($loginError == "fail") {
        echo "<p class='error'>Your username or password was incorrect. Please try again.</p>";
      } elseif ($loginError == "empty") {
        echo "<p class='error'>Please fill out the form completely.</p>";
      } elseif ($addProductCheck == "error") {
        echo "<p class='error'>Login error. Please try again.</p>";
        echo $_GET('msg');
      }
    }
    ?>
  </div>

  <?php
}
?>

<!-- / content -->

<!-- footer -->
<?php
include 'footer.php';
?>
<!-- / footer -->

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

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