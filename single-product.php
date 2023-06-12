<?php
include_once 'includes/dbh.inc.php';
include 'header-pt1.php';
$title = 'Doorbell Designs';
echo $title;
include 'header-pt2.php';
global $pdo;

//Retrieve all active products in category
if (strtolower($_GET['category']) === 'doorbells' 
            && $_GET['subcategory'] !== 'all') {
    $get_category_products_sql = 'SELECT * FROM products WHERE mainCategory = "' . $_GET['category'] . '" AND subCategories LIKE "[\"' . $_GET['subcategory'] . '\"]" AND active = 1;';
} else {
    $get_category_products_sql = 'SELECT * FROM products WHERE mainCategory = "' . $_GET['category'] . '" AND active = 1;';
}


/* Execute the query */
try {
    $res1 = $pdo->prepare($get_category_products_sql);
    $res1->execute();
} catch (PDOException $e) {
    /* If there is a PDO exception, throw a standard exception */
    throw new Exception('Database query error');
}

//Load the item we want.  On prev or next load the next/prev product.
$categoryProdIds = array();
$picUrls = array();
$productRow = null;
while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
  $currentRow = $row;  
  //Find the index where the current product's ID resides.
  if ($_GET['product'] != null && $row['id'] == $_GET['product']) {
    $productRow = $row; 
  }
  //Make an array of all the product IDs in the category
  $categoryProdIds[] = $row['id'];
  // echo print_r($categoryProdIds);
}
if ($productRow != null) {
  $currentRow = $productRow;
}
$get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " . $currentRow['id'] . ";";
try {
  $res2 = $pdo->prepare($get_image_urls_sql);
  $res2->execute();
} catch (PDOException $e) {
  throw new Exception('Database query error');
}
while ($urlRow = $res2->fetch(PDO::FETCH_ASSOC)) {
  $picUrls[] = str_replace('upload/', 'upload/c_fill,h_1200/', $urlRow['url']);
}

for ($i = 0; $i < count($categoryProdIds); $i++) {
    if ($categoryProdIds[$i] == $currentRow['id']) {
        $currentRowIndex = $i;
        break;
    }
}

?>
<ol class="breadcrumb">
  <li><a href="index.php">Home</a></li>
  <li>
    <div class="dropdown">
      <div class="dropdown-toggle" type="button" data-toggle="dropdown">
        <a href="<?php echo strtolower($_GET['category']) ?>.php"><?php echo ucfirst($_GET['category']) ?></a>
        <span class="caret"></span>
      </div>
      <ul class="dropdown-menu">
        <li><a href="doorbells.php">Doorbells</a></li>
        <li><a href="fan-pulls.php">Fan Pulls</a></li>
        <li><a href="air-plant-cradles.php">Air Plant Cradles</a></li>
      </ul>
    </div>
  </li>
<?php if ($_GET['subcategory'] != null) { 
  $subcat = $subcatStr = $_GET['subcategory'];
  if ($subcat === '%') {
    $subcatStr = 'All'; 
  } ?>
  <li>
    <div class="dropdown">
      <div class="dropdown-toggle" type="button" data-toggle="dropdown">
      <a href="<?php echo strtolower($_GET['category']) . '.php#' . strtolower($subcat) ?>"><?php echo ucfirst($subcatStr) ?></a>
      <span class="caret"></span>
      </div>
      <ul class="dropdown-menu">
        <li><a href="single-product.php?category=doorbells&subcategory=all" data-group="all">All</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=beachy" data-group="beachy">Beachy</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=contemporary" data-group="contemporary">Contemporary</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=dog" data-group="dog">Dog Lovers</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=animals" data-group="animals">Animals</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=petroglyphs" data-group="petroglyphs">Petroglyphs</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=plants" data-group="plants">Plants</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=one" data-group="one">One Of A Kind</a></li>
        <li><a href="single-product.php?category=doorbells&subcategory=miscellaneous" data-group="miscellaneous">Miscellaneous</a></li>
      </ul>
    </div>
  <?php } ?>
  </li> 
  <li class="active"><?php echo $currentRow['itemNameString'] ?></li>
</ol>
</header>
<!-- / header -->

<!-- content -->

<!-- shop single-product -->
<section id="single-product-page">
    <div class="container">
        <div class="row">

<?php

if ($currentRow) {
    if ($currentRow['mainCategory'] === 'Fan-Pulls') {
        $price = json_decode($currentRow['priceArray'])[0] . ' ea. / $' . json_decode($currentRow['priceArray'])[1] . ' per pair';
    } else {
        $price = json_decode($currentRow['priceArray'])[0];
    }

    ?> 

                <!-- product content area -->
                <div class="col-sm-6 col-md-7 content-area">
                    <div class="product-content-area">
                        <div id="product-slider" class="carousel slide" data-ride="carousel" data-interval="false">
                            <!-- wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img class="product-single-image" src="<?php echo $picUrls[0] ?>" alt="<?php echo $currentRow['itemNameString'] ?>">
                                </div>
                        <?php if (count($picUrls) > 1) {
                            for ($i = 1; $i < count($picUrls); $i++) { ?>
                                        <div class="item">
                                            <img class="product-single-image" src="<?php echo $picUrls[$i] ?>" alt="<?php echo $currentRow['itemNameString'] . ' ' . $i + 1 ?>">
                                        </div>
                                <?php } ?>         
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
                    </div>
                    <!-- / product-content-area -->

                    <!-- product pagination -->
                <?php if (count($categoryProdIds) > 1) { ?>
                    <div class="pagination no-padding">
                        <a href="single-product.php?category=<?php echo $currentRow['mainCategory'];
                         if (strtolower($_GET['category']) === 'doorbells') {
                            echo '&subcategory=' . $_GET['subcategory'];
                        } ?>&product=<?php
                          if ($currentRowIndex == 0) {
                              echo $categoryProdIds[count($categoryProdIds) - 1];
                          } else {
                              echo $categoryProdIds[$currentRowIndex - 1];
                          }
                          ?>
                        " class="btn btn-default btn-rounded no-margin"><i class="fa fa-long-arrow-left"></i><span>Previous</span></a>
                        <a href="single-product.php?category=<?php echo $currentRow['mainCategory']; 
                        if (strtolower($_GET['category']) === 'doorbells' ) {
                            echo '&subcategory=' . $_GET['subcategory'];
                        } ?>&product=<?php
                           if ($currentRowIndex == count($categoryProdIds) - 1) {
                               echo $categoryProdIds[0];
                           } else {
                               echo $categoryProdIds[$currentRowIndex + 1];
                           }
                           ?>
                        " class="btn btn-default btn-rounded no-margin pull-right"><span>Next</span><i class="fa fa-long-arrow-right"></i></a>
                    </div>
                <?php } ?>
                    <!-- / product pagination -->       

                </div>
                <!-- / project-content-area -->

                <!-- project sidebar area -->
                <div class="col-sm-6 col-md-5 product-sidebar">
                    <div class="product-details">
                        <h4 class="product-name"><?php echo $currentRow['itemNameString'] ?></h4>
                 
                        <div class="product-info">
                            <div class="info">
                                <p><i class="lnr lnr-tag"></i><span>Price: <?php echo '$' . $price; ?></span>
                                </p>
                            </div>
                            <div class="info">
                                <p><i class="lnr lnr-heart"></i><span>Category: <a href="<?php echo strtolower($currentRow['mainCategory']) ?>.php"> <?php echo $currentRow['mainCategory'] ?></a>

                                <!-- Loop through subcategory array. Add name of each subcategory with link to subcategory page.-->
                                <?php
                                $subCatArr = JSON_decode($currentRow['subCategories']);
                                foreach ($subCatArr as $i) {
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
                                            , <a href="<?php echo strtolower($currentRow['mainCategory']) ?>.php#<?php echo $i ?>"><?php echo ucfirst($i) ?></a> <?php
                                }
                                ?>

                                </span></p>
                            </div>
                            <div class="info">
                                <p><img class="ruler" src="images/ruler.png"><span>Dimensions: <?php echo $currentRow['dimensions'] ?></span></p>
                            </div>
                            <div class="info">
                                <?php if (strtolower($currentRow['mainCategory']) === 'doorbells') { ?>
                                    <p>All dimensions are approximate and can be up to 1/2" larger or smaller than stated.</p>
                                <?php } ?>
                            </div>
                        </div><!-- / product-info -->

                        <form onSubmit="return addToCart(event)">
                            <div class="buy-product">
                                <div class="options">
                                    <div>
                                        <span class="qty-span">Qty:</span>
                                        <input type="number" step="1" min="0" name="cart" value="1" title="Qty" class="input-text qty text" size="4">
                                    </div>
                                    <!-- <span class="selectors"> -->

                            <?php $get_options_sql = "SELECT * FROM options;";

                            try {
                                $res3 = $pdo->prepare($get_options_sql);
                                $res3->execute();
                            } catch (PDOException $e) {
                                throw new Exception('Database query error');
                            }
                            while ($optionRow = $res3->fetch(PDO::FETCH_ASSOC)) {
                                $optionIDs = json_decode($currentRow['optionIDs']);
                                if (in_array($optionRow['id'], $optionIDs)) {
                                    ?>
                                                <select class="selectpicker" data-id="<?php echo $optionRow['id'] ?>" required>
                                                    <option hidden value=""><?php echo $optionRow['name'] ?>:</option>
                                        
                                                <?php $optionValues = json_decode($optionRow['optionValues']);
                                                foreach ($optionValues as $key => $val) {
                                                    ?>
                                                            <option data-id="<?php echo $key ?>"><?php echo ucfirst($val) ?></option>
                                                <?php
                                                }
                                                ?>
                                                    </optgroup>
                                                </select>
                                    <?php
                                }
                            }
                            ?>
                                    <!-- </span> -->
                                </div>
                                <!-- / options -->

                                <div class="btn-container">
                                    <button type="submit" class="btn btn-primary-filled btn-rounded" id="<?php echo $currentRow['itemName'] ?>"><i class="lnr lnr-cart"></i><span> Add to Cart</span></button>
                                    <a href="shopping-cart.php" class="btn btn-success-filled btn-rounded"><i class="lnr lnr-checkmark-circle"></i><span> Checkout</span></a>
                                </div>
                            </div>
                        </form>
                    </div><!-- product-details -->
                </div><!-- / col-sm-4 col-md-3 -->
                <!-- / project sidebar area -->
            </div><!-- / row -->
    
<?php

} else {
    echo 'Error retrieving product.';
}

?>    
            
            </div><!-- / container -->
</section>
<!-- / shop single-product -->

<!-- toast container -->
<div class="toast-container"></div>
<!-- / toast container -->


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

<!-- subcategory -->
<script src="js/subcategory.js"></script>
<!-- / subcategory -->

<!-- / javascript -->
</body>

</html>