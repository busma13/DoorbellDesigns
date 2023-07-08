<?php
include_once 'src/Dbh.php';
include 'header-pt1.php';
$title = 'Doorbell Designs - About';
echo $title;
include 'header-pt2.php';
?>

<div id="page-header" class="not-found">
  <div class="container">
    <div class="page-header-content text-center">
      <div class="page-header wsub">
        <h1 class="page-title fadeInDown animated first">404 Error</h1>
      </div><!-- / page-header -->
      <p class="slide-text fadeInUp animated second">Page Not Found</p>
    </div><!-- / page-header-content -->
  </div><!-- / container -->
</div><!-- / page-header -->
<hr>
</header>
<!-- / header -->

<!-- content -->

<p class="whitespace">The URL <?php echo $_SERVER['REQUEST_URI']; ?> does not exist.</p>
<div class="space-top text-center">
  <a href="index.php">Back to home page</a>
</div>

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

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>