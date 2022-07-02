<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs Admin - Add Product';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="checkout">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Add Product</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second">Fill out this form to add a new product to your website</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<!-- content -->

<form action="./includes/product-management.inc.php" method="POST">
    <label for="itemNameString">Item name:</label>
    <input type="text" name="itemNameString" placeholder="Item name" id="itemNameString">
    
    <p>Main category type: </p>
    <input type="radio" name="mainCategory" value="doorbells" id="doorbells">
    <label for="doorbells">Doorbells</label>
    <input type="radio" name="mainCategory" value="artwork" id="artwork">
    <label for="artwork">Artwork</label>
    <input type="radio" name="mainCategory" value="miscellaneous" id="miscellaneous">
    <label for="miscellaneous">Miscellaneous</label>

    <label for="subcategory">Subcategory:</label>
    <input type="text" name="Subcategory" placeholder="subcategory" id="subcategory">

    <label for="price">Price (xx.xx format):</label>
    <input type="number" name="price" placeholder="Price" id="price">

    <label for="shipping">Shipping (xx.xx format):</label>
    <input type="number" name="shipping" placeholder="Shipping" id="shipping">

    <label for="pageUrl">page URL:</label>
    <input type="text" name="pageUrl" placeholder="Page URL" id="pageUrl">

    <label for="image">Image:</label>
    <input type="file" name="image" placeholder="Image" id="image">

    <!-- <label for="itemNameString">Item name:</label>
    <input type="text" name="itemNameString" placeholder="Item name" id="itemNameString"> -->
</form>

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