<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Ceiling Fan Pulls';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="shop-full">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Ceiling Fan Pulls</h1>
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
                    <li><a href="#" data-group="saguaros">Saguaros</a></li>
                    <li><a href="#" data-group="hamsas">Hamsas</a></li>
                    <li><a href="#" data-group="hearts">Hearts</a></li>
                    <li><a href="#" data-group="rods">Rods</a></li>
                    <!-- <li><a href="#" data-group="misc">Miscellaneous</a></li> -->
                    <!-- <li><a href="#" data-group="custom">Custom Orders</a></li> -->
                </ul>
                <!-- / product filter -->
                <div id="grid" class="row">

                    <?php
                        $get_fan_pull_products_sql = "SELECT * FROM products WHERE mainCategory='fan-pulls' and active='1';";

                        /* Execute the query */
                        try
                        {
                            $res = $pdo->prepare($get_fan_pull_products_sql);
                            $res->execute();
                        }
                        catch (PDOException $e)
                        {
                        /* If there is a PDO exception, throw a standard exception */
                        throw new Exception('Database query error');
                        }
                        $rows = $res->rowCount();
                        if ($rows === 0) {
                            echo '<div class="col-xs-6 col-md-3 product">';
                            echo '<p>There are no products of this type available currently.</p>
                            </div>'; 
                        } 
                        else {
                            while ($row = $res->fetch(PDO::FETCH_ASSOC)) { ?>
                                
                                <!-- product -->
                                <div class="col-xs-6 col-md-3 product" data-groups=<?php echo $row['subCategories'] ?>>
                                    <a href="single-product.php?category=fan-pulls&product=<?php echo $row['id'] ?>" class="product-link"></a>
                                    <!-- / product-link -->
                                    <img src="images/<?php echo strtolower($row['mainCategory']) . '-medium/' . $row['imgUrl'] ?>" alt="<?php echo $row['itemNameString'] ?>">
                                    <!-- / product-image -->

                                    <!-- product-hover-tools -->
                                    <!-- <div class="product-hover-tools">
                                        <a href="single-product.php?category=doorbells&product=< ?php echo $row['id'] ?>" class="view-btn">
                                            <i class="lnr lnr-eye"></i>
                                        </a>
                                        <a class="add-to-cart trigger" id="< ?php echo $row['itemName'] ?>">
                                            <i class="lnr lnr-cart"></i>
                                        </a>
                                    </div>/ product-hover-tools -->

                                    <!-- product-details -->
                                    <div class="product-details">
                                        <h3 class="product-title"><?php echo $row['itemNameString'] ?></h3>
                                        <h6 class="product-price">$<?php echo $row['price'] ?></h6>
                                    </div><!-- / product-details -->
                                </div><!-- / product -->
                    <?php   
                            }     
                        }
                    ?>

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

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- shuffle grid-resizer -->
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/custom-fan.js"></script>

<!-- / shuffle grid-resizer -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>