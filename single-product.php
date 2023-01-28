<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs';
    echo $title;
    include 'header-pt2.php';
	global $pdo;
?>

</header>
<!-- / header -->

<!-- content -->

<!-- shop single-product -->
<section id="single-product-page">
    <div class="container">
        <div class="row">

<?php

//Retrieve all active products in category
$get_category_products_sql = 'SELECT * FROM products WHERE mainCategory = "'.$_GET['category'].'" AND active = 1;';

/* Execute the query */
try
{
    $res1 = $pdo->prepare($get_category_products_sql);
    $res1->execute();
}
catch (PDOException $e)
{
/* If there is a PDO exception, throw a standard exception */
throw new Exception('Database query error');
}

//Load the item we want.  On prev or next load the next/prev product.
$categoryProdIds = array();
$picUrls = array();
$currentRow;
while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
    //Find the index where the current product's ID resides.
    if ($row['id'] == $_GET['product']) {
        $currentRow = $row;
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
        while ($urlRow = $res2->fetch(PDO::FETCH_ASSOC)) {

            $picUrls[] = str_replace('upload/', 'upload/c_fill,h_1200/',$urlRow['url']);
        }
    }
    //Make an array of all the product IDs in the category
    $categoryProdIds[] = $row['id'];
    // echo print_r($categoryProdIds);
}

for ($i = 0; $i < count($categoryProdIds); $i++) {
    if ($categoryProdIds[$i] == $currentRow['id']) {
        $currentRowIndex = $i;
        break;
    }
}

if ($currentRow) {
 
?> 

            <!-- product content area -->
            <div class="col-sm-6 col-md-7 content-area">
                <div class="product-content-area">
                    <div id="product-slider" class="carousel slide" data-ride="carousel">
                        <!-- wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <!-- TODO: remove if/else below. Add loop here to cycle through img array and load each img & alt -->
                            <div class="item active">
                            <img class="product-single-image" src="<?php echo $picUrls[0] ?>" alt="<?php echo $row['itemNameString'] ?>">
                            </div>
                    <?php if (strtolower($currentRow['mainCategory']) === 'air-plant-cradles') { ?>
                            <div class="item">
                            <img class="product-single-image" src="<?php echo $picUrls[1] ?>" alt="<?php echo $row['itemNameString'] ?>">
                            </div>
                        </div>
                        <!-- / wrapper for slides -->

                        <!-- controls -->
                        <a class="left carousel-control" href="#product-slider" role="button" data-slide="prev">
                            <span class="lnr lnr-chevron-left" aria-hidden="true"></span>
                        </a>
                        <a class="right carousel-control" href="#product-slider" role="button" data-slide="next">
                            <span class="lnr lnr-chevron-right" aria-hidden="true"></span>
                        </a>
                        <!-- / controls -->
                    <?php } else { ?>
                        </div>
                    <?php } ?>   
                    </div><!-- / product-slider -->
                </div><!-- / product-content-area -->

                <!-- product pagination -->
                <div class="pagination no-padding">
                    <a href="single-product.php?category=<?php echo $currentRow['mainCategory']?>&product=<?php 
                        if ($currentRowIndex == 0) {
                            echo $categoryProdIds[count($categoryProdIds)-1];
                        } else {
                            echo $categoryProdIds[$currentRowIndex - 1];
                        }
                    ?>
                    " class="btn btn-default btn-rounded no-margin"><i class="fa fa-long-arrow-left"></i><span>Previous</span></a>
                     <a href="single-product.php?category=<?php echo $currentRow['mainCategory']?>&product=<?php 
                        if ($currentRowIndex == count($categoryProdIds) - 1) {
                            echo $categoryProdIds[0];
                        } else {
                            echo $categoryProdIds[$currentRowIndex + 1];
                        }
                    ?>
                    " class="btn btn-default btn-rounded no-margin pull-right"><span>Next</span><i class="fa fa-long-arrow-right"></i></a>
                </div><!-- / product pagination -->       

            </div>
            <!-- / project-content-area -->

            <!-- project sidebar area -->
            <div class="col-sm-6 col-md-5 product-sidebar">
                <div class="product-details">
                    <h4 class="product-name"><?php echo $currentRow['itemNameString']?></h4>
                 
                    <div class="product-info">
                        <div class="info">
                            <p><i class="lnr lnr-tag"></i><span>Price: <?php echo '$' . $currentRow['price'] ?> ea.</span></p>
                        </div>
                        <div class="info">
                            <p><i class="lnr lnr-heart"></i><span>Category: <a href="<?php echo strtolower($currentRow['mainCategory'])?>.php"> <?php echo $currentRow['mainCategory']?></a>

                            <!-- Loop through subcategory array. Add name of each subcategory with link to subcategory page.-->
                            <?php 
                                $subCatArr = JSON_decode($currentRow['subCategories']);
                                foreach($subCatArr as $i) { 
                                    if ($i === '') {
                                        continue;
                                    }
                                    if ($i === 'dog') {
                                        $i = "dog lovers";
                                    }
                                    if ($i === 'one') {
                                        $i = "one of a kind";
                                    }
                                    ?>
                                    , <a href="<?php echo strtolower($currentRow['mainCategory'])?>.php?category=<?php echo $i?>"><?php echo ucfirst($i)?></a> <?php
                                }
                            ?>

                            </span></p>
                        </div>
                        <div class="info">
                            <p><img class="ruler" src="images/ruler.png"><span>Dimensions: <?php echo $currentRow['dimensions']?></span></p>
                        </div>
                        <div class="info">
                            <?php if (strtolower($currentRow['mainCategory']) === 'doorbells') { ?>
                            <p>All dimensions are approximate and can be up to 1/2" larger or smaller than stated.</p>
                            <?php } ?>
                        </div>
                    </div><!-- / project-info -->

                    <div class="buy-product">
                        <div class="options">
                            <span>Qty:</span>
                            <input type="number" step="1" min="0" name="cart" value="1" title="Qty" class="input-text qty text" size="4">
                            <?php
                            if (strtolower($currentRow['mainCategory']) !== 'air-plant-cradles') { ?>
                            <span class="selectors">
                                <select class="selectpicker">
                                    <?php 
                                    
                                    if (strtolower($currentRow['mainCategory']) === 'fan-pulls') {
                                        echo '<optgroup label="Chain Color:">';
                                    } else if (strtolower($currentRow['mainCategory']) === 'doorbells') {
                                        echo '<optgroup label="Base Color:">';
                                    }
                                    $baseColorArr = JSON_decode($currentRow['baseColor']);
       
                                    foreach($baseColorArr as $i) {
                                ?>
                                        <option><?php echo ucfirst($i)?></option>
                                <?php 
                                    } 
                                ?>
                                    </optgroup>
                                </select>
                            </span>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- / options -->

                        <div class="space-25">&nbsp;</div>

                        <a class="btn btn-primary-filled btn-rounded add-to-cart-single" id="<?php echo $currentRow['itemName']?>"><i class="lnr lnr-cart"></i><span> Add to Cart</span></a>
                        <a href="shopping-cart.php" class="btn btn-success-filled btn-rounded"><i class="lnr lnr-checkmark-circle"></i><span> Checkout</span></a>
                    </div>
                </div><!-- product-details -->
            </div><!-- / col-sm-4 col-md-3 -->
            <!-- / project sidebar area -->
        </div><!-- / row -->
    
<?php
        
    }
    else {
        echo 'Error retrieving product.';
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

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- / javascript -->
</body>

</html>