<?php
    session_start();
    include_once './includes/dbh.inc.php';

    /* Include the Account class file */
    include './includes/account-class.php';

    /* Create a new Account object */
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
                <p class="slide-text fadeInUp animated second">Please log in to acces your admin panel</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

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
    {
        echo 'You are logged in as: ' . $account->getName() . '<br>';

        ?>
            <a href="./admin-panel.php" class="btn btn-primary-filled btn-rounded no-margin"></i><span>Go To Admin Panel</span></a>

            <form action="./includes/admin-login.inc.php" method="POST">
                <button type="submit" name="logout" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log out</button>
            </form>
        <?php
    } 
    else {
        
?>


<!-- content -->

<form action="./includes/admin-login.inc.php" method="POST">
    <label for="userName">User name:</label>
    <input type="text" name="userName" placeholder="User name" id="userName">

    <label for="password">Password:</label>
    <input type="password" name="password" placeholder="Password" id="password">
<!-- 
    <input type="submit" name="submit" class="btn btn-default btn-rounded no-margin" value="Login"/> -->
    <button type="submit" name="login" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log in</button>

</form>


<!-- / content -->

<!-- footer -->
<?php
    include 'footer.php';
?>
<!-- / footer -->

<?php
    }
?>

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