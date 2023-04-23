<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs';
    echo $title;
    include 'header-pt2.php';

    /* Global $pdo object */
	global $pdo;
?>

    <div id="page-header" class="index">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub shift-down">
                    <!-- <h1 class="page-title fadeInDown animated first">Doorbell Designs</h1> -->
                    <h1 class="page-title fadeInDown animated first"><img class="fullscreen-logo hide-logo-large"src="images/logo-dd.jpg"></h1>
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

<!-- content -->

<!-- categories -->
<section id="categories">
    <div class="container">
        <div class="page-header text-center wsub">
            <h2>Shop Categories</h2>
        </div><!--/ page-header -->
        <p class="title-description text-center"></p>
        <div class="row">

            <div class="col-sm-4 category">
                <a href="doorbells.php?category=all">
                    <div class="category-item">
                        <img src="images/homepage/welcomeDoorbell.jpg" alt="Doorbells">
                        <div class="overlay">
                            <div class="caption">
                                <h4>Doorbells</h4>
                            </div>
                        </div>
                    </div><!-- / category-item -->
                </a>
            </div><!-- / category -->

            <div class="col-sm-4 category">
                <a href="fan-pulls.php">
                    <div class="category-item">
                        <img src="images/homepage/fan-pulls.jpg" alt="Fan Pulls">
                        <div class="overlay">
                            <div class="caption">
                                <h4>Ceiling Fan Pulls</h4>
                            </div>
                        </div>
                    </div><!-- / category-item -->
                </a>
            </div><!-- / category -->

            <div class="col-sm-4 category">
                <a href="air-plant-cradles.php">
                    <div class="category-item">
                        <img src="images/homepage/lotusBlossomCradleSquare.jpg" alt="Air Plant Cradles">
                        <div class="overlay">
                            <div class="caption">
                                <h4>Air Plant Cradles</h4>
                            </div>
                        </div>
                    </div><!-- / category-item -->
                </a>
            </div><!-- / category -->

        </div><!-- / row -->
    </div><!-- / container -->
</section>
<!-- / categories -->

<!-- featured-products -->
<section id="featured-products">
    <div class="page-header text-center wsub">
        <h2>Featured Products</h2>
    </div><!--/ page-header -->
    <div id="products-carousel" class="owl-carousel">

    <?php
        // Retrieve featured products from database and insert into html
        $get_products_sql = "SELECT * FROM products WHERE featured = '1';";

        /* Execute the query */
        try
        {
            $res1 = $pdo->prepare($get_products_sql);
            $res1->execute();
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }
        while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
            $get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " .$row['id'] . ";";

            try
            {
                $res2 = $pdo->prepare($get_image_urls_sql);
                $res2->execute();
            }
            catch (PDOException $e)
            {
            throw new Exception('Database query error');
            }
            $urlRow = $res2->fetch(PDO::FETCH_ASSOC); 
            $picUrl = str_replace('upload/', 'upload/c_fill,h_800/',$urlRow['url']); 
            $price = json_decode($row['priceArray'])[0]; ?>

            <!-- item -->
            <div class="item product">
                <!-- <span class="sale-label">SALE</span> -->
                <!-- / sale-label -->
                <a href="single-product.php?category=<?php echo $row['mainCategory'] ?>&product=<?php echo $row['id'] ?>&subcategory=%" class="product-link"></a>
                <!-- / product-link -->
                <img src="<?php echo $picUrl ?>" alt="<?php echo $row['itemNameString'] ?>">
                <!-- / product-image -->

                <!-- product-hover-tools -->
                <!-- <div class="product-hover-tools">
                    <a href="single-product.php?product=<?php echo $row['id'] ?>" class="view-btn">
                        <i class="lnr lnr-eye"></i>
                    </a>
                    <a class="add-to-cart" id="<?php echo $row['itemName'] ?>">
                        <i class="lnr lnr-cart"></i>
                    </a>
                </div> -->
                <!-- / product-hover-tools -->

                <!-- product-details -->
                <div class="product-details">
                    <h3 class="product-title"><?php echo $row['itemNameString'] ?></h3>
                    <?php if ($row['mainCategory'] === 'Fan-Pulls') { ?>
                        <h6 class="product-price">$<?php echo $price ?> ea.</h6>
                    <?php } else { ?>
                        <h6 class="product-price">$<?php echo $price ?></h6>
                    <?php } ?>
                </div>
                <!-- / product-details -->
            </div>
            <!-- / item -->
            <?php   
            
        }
   ?>
           
    </div> <!-- / products-carousel -->
</section>
<!-- / featured-products -->

<!-- shop 3col -->
<section id="shop">
    <div class="page-header text-center wsub">
        <h2>New Arrivals</h2>
    </div><!--/ page-header -->
    <div class="container">
        <div id="grid" class="row">

        <?php
        // // Retrieve new arrivals from database and insert into html
        $get_products_sql = "SELECT * FROM `products` ORDER BY id DESC LIMIT 9;";

        /* Execute the query */
        try
        {
            $res3 = $pdo->prepare($get_products_sql);
            $res3->execute();
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }

        while ($row = $res3->fetch(PDO::FETCH_ASSOC)) {
            $get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " .$row['id'] . ";";

            try
            {
                $res4 = $pdo->prepare($get_image_urls_sql);
                $res4->execute();
            }
            catch (PDOException $e)
            {
            throw new Exception('Database query error');
            }
            $urlRow = $res4->fetch(PDO::FETCH_ASSOC); 
            $newArrivalPicUrl = str_replace('upload/', 'upload/c_fill,h_800/',$urlRow['url']); 
            $price = json_decode($row['priceArray'])[0]; ?>
            

            <!-- product -->
            <div class="col-xs-6 col-md-4 product">
                <!-- <span class="sale-label">SALE</span> -->
                <!-- / sale-label -->
                <a href="single-product.php?category=<?php echo $row['mainCategory'] ?>&product=<?php echo $row['id'] ?>&subcategory=%" class="product-link"></a>
                <!-- / product-link -->
                <img src="<?php echo $newArrivalPicUrl ?>" alt="<?php echo $row['itemNameString'] ?>">
                <!-- / product-image -->

                <!-- product-details -->
                <div class="product-details">
                    <h3 class="product-title"><?php echo $row['itemNameString'] ?></h3>
                    <?php if ($row['mainCategory'] === 'Fan-Pulls') { ?>
                        <h6 class="product-price">$<?php echo $price ?> ea.</h6>
                    <?php } else { ?>
                        <h6 class="product-price">$<?php echo $price ?></h6>
                    <?php } ?>
                </div>
                <!-- / product-details -->
            </div>
            <!-- / item -->
            <?php   
            
        }
   ?>

            <!-- grid-resizer -->
            <div class="col-xs-6 col-md-4 shuffle_sizer"></div>
            <!-- / grid-resizer -->

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

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- sliders -->
<script src="js/owl.carousel.min.js"></script>
<!-- featured-products carousel -->
<script>
    $(document).ready(function() {
      $("#products-carousel").owlCarousel({
        autoPlay: 3000, //set autoPlay to 3 seconds.
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
      });

    });
</script>
<!-- / featured-products carousel -->
<!-- / sliders -->

<!-- shuffle grid-resizer -->
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/custom.js"></script>
<!-- / shuffle grid-resizer -->

<!-- preloader -->
<!-- <script src="js/preloader.js"></script> -->
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>