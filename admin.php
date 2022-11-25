<?php
    session_start();
    include_once './includes/dbh.inc.php';
    include './includes/account-class.php';
    $account = new Account();
    include_once 'includes/dbh.inc.php';
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
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->
    <hr>
</header>
<!-- / header -->

<?php
    $login = FALSE;

    try
    {
        $login = $account->sessionLogin();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        die();
    }

    if ($login)
    { ?>
        
        <div class="log-in flex-container space-top-2x space-bottom-2x">
            <p class="space-top text-center">You are logged in as: <?php echo $account->getName() ?></p>
            <div class="space-top flex-container logged-in">
                <a href="./admin-panel.php" class="btn btn-primary-filled btn-rounded"><span>Go To Admin Panel</span></a>

                <form action="./includes/admin-login.inc.php" method="POST">
                    <button type="submit" name="logout" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log out</button>
                </form>
            </div>
        </div>
<?php
    } 
    else {
        
?>

<!-- content -->

<form action="./includes/admin-login.inc.php" method="POST" class="log-in flex-container space-top-2x space-bottom-2x">
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