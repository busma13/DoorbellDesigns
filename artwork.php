<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Artwork';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="shop-full">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Artwork</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second">Your page's description goes here...</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<!-- content -->

<!-- shop 3col -->
<section id="shop">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 content-area">
                <!-- product filter -->
                <ul class="product-filter list-inline text-center">
                    <li><a href="#" data-group="all" class="active">All</a></li>
                    
                    <li><a href="#" data-group="custom">Custom Orders</a></li>
                </ul>
                <!-- / product filter -->
                <div id="grid" class="row">
                    <!-- product -->
                    <div class="col-xs-6 col-md-3 product" data-groups='["plants"]'>
                        <a href="bamboo-doorbell.html" class="product-link"></a>
                        <!-- / product-link -->
                        <img src="images/doorbells/bamboo_9to10.jpg" alt="Bamboo Doorbell">
                        <!-- / product-image -->

                        <!-- product-hover-tools -->
                        <div class="product-hover-tools">
                            <a href="bamboo-doorbell.html" class="view-btn">
                                <i class="lnr lnr-eye"></i>
                            </a>
                            <a href="shopping-cart.html" class="add-to-cart">
                                <i class="lnr lnr-cart"></i>
                            </a>
                        </div><!-- / product-hover-tools -->

                        <!-- product-details -->
                        <div class="product-details">
                            <h3 class="product-title">Bamboo</h3>
                            <h6 class="product-price">$59</h6>
                        </div><!-- / product-details -->
                    </div><!-- / product -->

                

                    <!-- grid-resizer -->
                    <div class="col-xs-6 col-md-3 shuffle_sizer"></div>
                    <!-- / grid-resizer -->

                </div><!-- / row -->

            </div><!-- / content-area -->

        </div><!-- / row -->
    </div><!-- / container -->
</section>
<!-- / shop 3col -->

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

<!-- shuffle grid-resizer -->
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/custom-art.js"></script>

<!-- / shuffle grid-resizer -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>