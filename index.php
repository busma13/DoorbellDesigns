<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs';
    echo $title;
    include 'header-pt2.php';

    /* Global $pdo object */
	global $pdo;
?>



    <!-- <div id="header-sliders">
        <!-- slider -- >
        <div id="slider" class="carousel slide">  
            <div class="carousel-inner">

                <!-- slide 1 -- >
                <div class="item active slide1 fashion">
                    <div class="container">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-md-12 slider-content">
                                    <h3 class="slide-title fadeInDown animated first">Doorbells</h3>
                                    <p class="slide-text flipInX animated second">Quisque vitae tempor libero. Cum sociis natoque penatibus et magnis dis parturient montes.</p>
                                    <a href="doorbells.php" class="btn btn-lg btn-primary-filled btn-pill fadeInUp animated third"><i class="lnr lnr-cart"></i> <span>Shop Now</span></a>
                                </div><!-- slider-content -- >
                            </div><!-- / row -- >
                        </div><!-- / carousel-caption -- >
                    </div><!-- / container -- >
                </div><!-- / slide 1 -- >

                <!-- slide 2 -- >
                <div class="item slide2 furniture">
                    <div class="container">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-md-12 slider-content">
                                    <h3 class="slide-title fadeInDown animated first">Ceiling Fan Pulls</h3>
                                    <p class="slide-text flipInX animated second">Vivamus facilisis sapien enim, eget lobortis ante faucibus vel. In hendrerit arcu eget arcu fringilla.</p>
                                    <a href="fan-pulls.php" class="btn btn-lg btn-primary-filled btn-pill fadeInUp animated third"><i class="lnr lnr-store"></i> <span>Visit Shop</span></a>
                                </div><!-- slider-content -- >
                            </div><!-- / row -- >
                        </div><!-- / carousel-caption -- >
                    </div><!-- / container -- >
                </div><!-- / slide 2 -- >

                <!-- slide 3 -- >
                <div class="item slide3 art">
                    <div class="container">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-md-12 slider-content">
                                    <h3 class="slide-title fadeInDown animated first">Air Plant Cradles</h3>
                                    <p class="slide-text flipInX animated second">Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus sapien libero.</p>
                                    <a href="air-plant-cradles.php" class="btn btn-lg btn-primary-filled btn-pill fadeInUp animated third"><i class="lnr lnr-store"></i> <span>Visit Shop</span></a>
                                </div><!-- slider-content -- >
                            </div><!-- / row -- >
                        </div><!-- / carousel-caption -- >
                    </div><!-- / container -- >
                </div><!-- / slide 3 -- >

            </div><!-- /carousel-inner -- >

            <!-- controls -- >
            <a class="left carousel-control" href="#slider" data-slide="prev"><span class="lnr lnr-chevron-left"></span></a>
            <a class="right carousel-control" href="#slider" data-slide="next"><span class="lnr lnr-chevron-right"></span></a>
            <!-- / controls -- >

        </div>
        <!-- / slider-- >
    </div>/ sliders -->
    <div id="page-header" class="about">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Doorbell Designs</h1>
                </div><!-- / page-header -->
                <!-- <p class="slide-text fadeInUp animated second"></p> -->
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
                <a href="doorbells.php">
                    <div class="category-item">
                        <img src="images/homepage/welcomeDoorbell.jpg" alt="">
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
                        <img src="images/homepage/fan-pulls.jpg" alt="">
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
                        <img src="images/homepage/lotusBlossomCradleSquare.jpg" alt="">
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
            $res2 = $pdo->prepare($get_products_sql);
            $res2->execute();
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }

        while ($row = $res2->fetch(PDO::FETCH_ASSOC)) { ?>

            <!-- item -->
            <div class="item product">
                <!-- <span class="sale-label">SALE</span> -->
                <!-- / sale-label -->
                <a href="single-product.php?category=<?php echo $row['mainCategory'] ?>&product=<?php echo $row['id'] ?>" class="product-link"></a>
                <!-- / product-link -->
                <img src="images/<?php echo strtolower($row['mainCategory']) . '-medium/' . $row['imgUrl'] ?>" alt="<?php echo $row['itemNameString'] ?>">
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
                    <h6 class="product-price">$<?php echo $row['price'] ?></h6>
                </div>
                <!-- / product-details -->
            </div>
            <!-- / item -->
            <?php   
            
        }
   ?>
    

        <!-- item -->
        <!-- <div class="item product">
            <a href="release-the-hounds.html" class="product-link"></a>
            <! -- / product-link -- >
            <img src="images/doorbells/to-release-the-hounds-1_9to10.jpg" alt="">
            <! -- / product-image -->

            <!-- product-hover-tools -- >
            <div class="product-hover-tools">
                <a href="release-the-hounds.html" class="view-btn">
                    <i class="lnr lnr-eye"></i>
                </a>
                <a href="shopping-cart.html" class="add-to-cart">
                    <i class="lnr lnr-cart"></i>
                </a>
            </div><! -- / product-hover-tools -- >

            <! -- product-details -- >
            <div class="product-details">
                <h3 class="product-title">Release The Hounds Doorbell</h3>
                <h6 class="product-price">$59</h6>
            </div><! -- / product-details -- >
        </div> -->
        <!-- / item -->

        
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
            $res4 = $pdo->prepare($get_products_sql);
            $res4->execute();
        }
        catch (PDOException $e)
        {
        /* If there is a PDO exception, throw a standard exception */
        throw new Exception('Database query error');
        }

        while ($row = $res4->fetch(PDO::FETCH_ASSOC)) { ?>

            <!-- product -->
            <div class="col-xs-6 col-md-4 product">
                <!-- <span class="sale-label">SALE</span> -->
                <!-- / sale-label -->
                <a href="single-product.php?category=<?php echo $row['mainCategory'] ?>&product=<?php echo $row['id'] ?>" class="product-link"></a>
                <!-- / product-link -->
                <img src="images/<?php echo strtolower($row['mainCategory']) . '-medium/' . $row['imgUrl'] ?>" alt="<?php echo $row['itemNameString'] ?>">
                <!-- / product-image -->

                <!-- product-hover-tools -->
                <!-- <div class="product-hover-tools">
                    <a href="single-product.php?category=<?php echo $row['mainCategory'] ?>&product=<?php echo $row['id'] ?>" class="view-btn">
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
                    <h6 class="product-price">$<?php echo $row['price'] ?></h6>
                </div>
                <!-- / product-details -->
            </div>
            <!-- / item -->
            <?php   
            
        }
   ?>

            
            
            <!-- product -->
            <!-- <div class="col-xs-6 col-md-4 product">
                <span class="sale-label">SALE</span>
                <a href="single-product.php" class="product-link"></a>
                <! -- / product-link -- >
                <img src="images/f-product.jpg" alt="">
                <! -- / product-image -->

                <!-- product-hover-tools -- >
                <div class="product-hover-tools">
                    <a href="single-product.php" class="view-btn">
                        <i class="lnr lnr-eye"></i>
                    </a>
                    <a href="shopping-cart.php" class="add-to-cart">
                        <i class="lnr lnr-cart"></i>
                    </a>
                </div><! -- / product-hover-tools -->

                <!-- product-details -- >
                <div class="product-details">
                    <h3 class="product-title">Leather Bag</h3>
                    <h6 class="product-price"><del>$149</del> <span class="sale-price">$79</span></h6>
                </div><!-- / product-details -- >
            </div>/ product -->

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

<!-- scrolling-nav -->
<script src="js/scrolling-nav.js"></script>
<!-- / scrolling-nav -->

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
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>