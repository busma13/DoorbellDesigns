<?php
include_once 'includes/dbh.inc.php';
include 'header-pt1.php';
$title = 'Doorbell Designs - Doorbells';
echo $title;
include 'header-pt2.php';

/* Global $pdo object */
global $pdo;
?>

    <div id="page-header" class="doorbells">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub shift-down">
                    <h1 class="page-title fadeInDown animated first">Doorbells</h1>
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
    <!-- <hr> -->
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
                    <li><a href="#" data-group="beachy">Beachy</a></li>
                    <li><a href="#" data-group="contemporary">Contemporary</a></li>
                    <li><a href="#" data-group="dog">Dog Lovers</a></li>
                    <li><a href="#" data-group="animals">Animals</a></li>
                    <li><a href="#" data-group="petroglyphs">Petroglyphs</a></li>
                    <li><a href="#" data-group="plants">Plants</a></li>
                    <!-- <li><a href="#" data-group="southwest">Southwest</a></li> -->
                    <li><a href="#" data-group="one">One Of A Kind</a></li>
                    <li><a href="#" data-group="miscellaneous">Miscellaneous</a></li>
                    <!-- <li><a href="./custom-orders.php" data-group="custom">Custom Orders</a></li> -->
                </ul>
                <!-- / product filter -->
                
                <div id="grid" class="row">

                    <?php
                    $get_doorbell_products_sql = "SELECT * FROM products WHERE mainCategory='Doorbells' and active='1';";

                    /* Execute the query */
                    try {
                        $res1 = $pdo->prepare($get_doorbell_products_sql);
                        $res1->execute();
                    } catch (PDOException $e) {
                        /* If there is a PDO exception, throw a standard exception */
                        throw new Exception('Database query error');
                    }
                    $rows = $res1->rowCount();
                    if ($rows === 0) {
                        echo '<div class="col-xs-6 col-md-3 product">';
                        echo '<p>There are no products of this type available currently.</p>
                            </div>';
                    } else {
                        while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
                            $get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " . $row['id'] . ";";

                            try {
                                $res2 = $pdo->prepare($get_image_urls_sql);
                                $res2->execute();
                            } catch (PDOException $e) {
                                throw new Exception('Database query error');
                            }
                            $urlRow = $res2->fetch(PDO::FETCH_ASSOC);
                            $picUrl = str_replace('upload/', 'upload/c_fill,h_800/', $urlRow['url']);
                            $price = json_decode($row['priceArray'])[0]; ?>
                                
                                                <!-- product -->
                                                <div class="col-xs-6 col-md-3 product" data-groups=<?php echo $row['subCategories'] ?>>
                                                    <a href="single-product.php?category=doorbells&product=<?php echo $row['id'] ?>" class="product-link"></a>
                                                    <!-- / product-link -->
                                                    <img src="<?php echo $picUrl ?>" alt="<?php echo $row['itemNameString'] ?>">
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
                                                        <h6 class="product-price">$<?php echo $price ?></h6>
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

<div class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h1>Hello, I am a modal!</h1>
    </div>
</div>

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- shuffle grid-resizer -->
<script src="js/jquery.shuffle.min.js"></script>
<script src="js/custom-doorbells.js"></script>

<!-- / shuffle grid-resizer -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>