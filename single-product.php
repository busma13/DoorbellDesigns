<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - ';//Add product name
    echo $title;
    include 'header-pt2.php';
?>

    <!-- <div id="page-header" class="single-product">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Single Product</h1>
                </div><! -- / page-header -->
                <!-- <p class="slide-text fadeInUp animated second">Your product's description goes here...</p> 
            </div><! -- / page-header-content -->
        <!-- </div>/ container -->
    <!-- </div>/ page-header -->

</header>
<!-- / header -->

<!-- content -->

<!-- shop single-product -->
<section id="shop">
    <div class="container">
        <div class="row">

<?php
    //Retrieve product by id
    $get_product_sql = 'SELECT * FROM products WHERE id = "'.$_GET['product'].'";';
    $productQueryResult = mysqli_query($conn, $get_product_sql);
    $productResultCheck = mysqli_num_rows($productQueryResult);
    
    if ($productResultCheck > 0) {
        while ($row = mysqli_fetch_assoc($productQueryResult)) {
?> 

            <!-- product content area -->
            <div class="col-sm-6 col-md-7 content-area">
                <div class="product-content-area">
                    <div id="product-slider" class="carousel slide" data-ride="carousel">
                        <!-- wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img class="product-single-image" src="<?php echo $row['imgUrl']?>" alt="<?php echo $row['itemNameString']?>">
                            </div>
                           
                        </div>
                        <!-- / wrapper for slides -->

                        <!-- controls -->
                        <!-- <a class="left carousel-control" href="#product-slider" role="button" data-slide="prev">
                            <span class="lnr lnr-chevron-left" aria-hidden="true"></span>
                        </a>
                        <a class="right carousel-control" href="#product-slider" role="button" data-slide="next">
                            <span class="lnr lnr-chevron-right" aria-hidden="true"></span>
                        </a> -->
                        <!-- / controls -->
                    </div><!-- / product-slider -->

                    
                    
                </div><!-- / product-content-area -->

                
                <!-- product pagination -->
                <div class="pagination no-padding">
                    <a href="single-product.php?product=<?php echo $_GET['product'] - 1?>" class="btn btn-default btn-rounded no-margin"><i class="fa fa-long-arrow-left"></i><span>Previous</span></a>
                     <a href="single-product.php?product=<?php echo $_GET['product'] + 1?>" class="btn btn-default btn-rounded no-margin pull-right"><span>Next</span><i class="fa fa-long-arrow-right"></i></a>
                </div><!-- / product pagination -->       

            </div>
            <!-- / project-content-area -->

            <!-- project sidebar area -->
            <div class="col-sm-6 col-md-5 product-sidebar">
                <div class="product-details">
                    <h4 class="product-name"><?php echo $row['itemNameString']?></h4>
                    <!-- <p>Maecenas bibendum erat in erat maximus, vel imperdiet leo mattis. Integer vitae pellentesque massa. Fusce ac suscipit neque. Etiam justo risus, tristique id feugiat a venenatis.</p> -->
                    <!-- <h4 class="space-top-30">Product Info</h4> -->
                    <div class="product-info">
                        <div class="info">
                            <p><i class="lnr lnr-tag"></i><span>Price: <?php echo '$' . $row['price'] ?></span></p>
                        </div>
                        <div class="info">
                            <p><i class="lnr lnr-heart"></i><span>Category: <a href="<?php echo strtolower($row['mainCategory'])?>.php"> <?php echo $row['mainCategory']?></a>, 

                            <!-- Loop through subcategory array. Add name of each subcategory with link to subcategory page.-->
                            <?php 
                                $subCatArr = JSON_decode($row['subCategories']);
                                // echo $subCatArr;
                                foreach($subCatArr as $i) { 
                                    // echo $i; 
                                    ?>
                                    <a href="<?php echo strtolower($row['mainCategory'])?>.php?category=<?php echo $i?>"><?php echo ucfirst($i)?></a> <?php
                                }
                            ?>

                            </span></p>
                        </div>
                        <div class="info">
                            <p><img class="ruler" src="images/ruler.png"><span>Dimensions: <?php echo $row['dimensions']?></span></p>
                        </div>
                        
                    </div><!-- / project-info -->

                    <div class="buy-product">
                        <div class="options">
                            <span>Qty:</span>
                            <input type="number" step="1" min="0" name="cart" value="1" title="Qty" class="input-text qty text" size="4">
                            <span class="selectors">
                                <select class="selectpicker">
                                    <optgroup label="Color:">
                                        <option>Grey</option>
                                        <option>Light Brown</option>
                                    </optgroup>
                                </select>
                                <!-- <select class="selectpicker two">
                                    <optgroup label="Color:">
                                        <option>Grey</option>
                                        <option>Black</option>
                                        <option>Blue</option>
                                    </optgroup>
                                </select> -->
                            </span>
                        </div>
                        <!-- / options -->

                        <div class="space-25">&nbsp;</div>

                        <a class="btn btn-primary-filled btn-rounded add-to-cart-single" id="bambooDoorbell"><i class="lnr lnr-cart"></i><span> Add to Cart</span></a>
                        <a href="shopping-cart.php" class="btn btn-success-filled btn-rounded"><i class="lnr lnr-checkmark-circle"></i><span> Checkout</span></a>
                    </div>

                    

                </div><!-- product-details -->

            </div><!-- / col-sm-4 col-md-3 -->
            <!-- / project sidebar area -->

        </div><!-- / row -->
    

        <?php
                }
            }

        ?>    
            
            </div><!-- / container -->
</section>
<!-- / shop single-product -->

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

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>