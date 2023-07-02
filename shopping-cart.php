<?php
include_once 'src/Dbh.php';
include 'header-pt1.php';
$title = 'Doorbell Designs - Cart';
echo $title;
include 'header-pt2.php';
?>

    <div id="page-header" class="shopping-cart">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Shopping Cart</h1>
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

<!-- shopping-cart -->
<div id="shopping-cart">
    <div class="container">
        <!-- shopping cart table -->
        <table class="shopping-cart">
            <thead>
                <tr>
                    <th class="image">&nbsp;</th>
                    <th>Product</th>
                    <th>Options</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody class="cart-table-body">
                <!-- Items in cart will be shown here -->
            </tbody>
        </table>
        <!-- / shopping cart table -->

        <div class="row cart-footer">
            <div class="coupon col-sm-6">
                <div class="input-group">
                    
                </div>
            </div><!-- / input-group -->
            <div class="update-cart col-sm-6">
            
            </div><!-- / update-cart -->

            <div class="col-sm-6 cart-total">
                <h4>Cart Total</h4>
                <p>Subtotal: <span class="subtotal">$0</span></p>
                <p>Shipping: <span class="shipping">$0</span></p>
                <p>Total: <span class="total">$0</span></p>
            </div><!-- / cart-total -->

            <div class="col-sm-6 cart-checkout">
                <a href="index.php#categories" class="btn btn-default-filled btn-rounded"><i class="lnr lnr-cart"></i> <span>Continue Shopping</span></a>
                <a href="checkout.php" class="btn btn-primary-filled btn-rounded go-to-checkout"><i class="lnr lnr-exit"></i> <span>Proceed to Checkout</span></a>
            </div><!-- / cart-checkout -->


        </div><!-- / row -->
    </div><!-- / container -->
</div>
<!-- / shopping-cart -->

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