<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Checkout';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="checkout">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Checkout</h1>
                </div><!-- / page-header -->
                <!-- <p class="slide-text fadeInUp animated second">Page description goes here...</p> -->
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->
    <hr>
</header>
<!-- / header -->

<!-- preloader -->
<div id="waitForRedirect">
    <div class="spinner spinner-round"></div>
    <div class="modal-content">
        <h1>Just a moment...</h1>
        <p>Redirecting to Square Payment Page</p>   
    </div>
</div>
<!-- / preloader -->

<!-- content -->

<!-- shopping-cart -->
<div id="checkout">
    <div class="container">
        <div class="row checkout-screen">
            <div class="col-sm-8 checkout-form">
                <h4 class="space-left">Checkout</h4>
                <!-- <p class="space-left have-account">Already have an account? <a href="login-register.html" class="btn btn-link"><i class="lnr lnr-enter"></i><span>Login</span></a></p> -->
                <form action="./includes/order.inc.php" method="POST" onsubmit="openSubmitOrderModal()">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="first-name" placeholder="*First name" required>
                            <input type="text" class="form-control" name="last-name" placeholder="*Last name" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control" name="tel" placeholder="*Mobile Phone" required>
                            <input type="email" class="form-control" name="email" placeholder="*Email" required>
                            
                        </div>
                    </div><!-- / row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="address-line" placeholder="*Address Line" required>
                            <select class="form-control stateSelect" name="state" required>
                                <optgroup label="State:">
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="city" placeholder="*City" required>
                            <input type="text" class="form-control" name="zip" placeholder="*ZIP Code" required>
                        </div>
                    </div><!-- / row -->

                    <input type="hidden" name="cart-list-input" id="cart-list-input" value="">

                    <div class="checkout-form-footer space-left space-right">
                        <!-- <textarea class="form-control" name="message" placeholder="Message" required></textarea> -->
                        <!-- <a href="" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-exit"></i><span>Checkout with Square</span></a> -->
                        <button type="submit" name="submit" id="checkout-btn" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-exit"></i><span>Checkout with Square</span></button>
                    </div><!-- / checkout-form-footer -->
                </form>

            
                <!-- Server side form validation notifications. -->
                <?php
                    if (!isset($_GET['order'])) {
                        //do nothing
                    }
                    else {
                        $orderCheck = $_GET['order'];
                        
                        if ($orderCheck == "empty") {
                            echo "<p id='message' class='text-danger space-left'>Please fill out all required fields.</p>";
                        }
                        elseif ($orderCheck == "email") {
                            echo "<p id='message' class='text-danger space-left'>Please enter a valid email.</p>";
                        }
                        elseif ($orderCheck == "error") {
                            echo "<p id='message' class='text-danger space-left'>Form submission error. Please try again.</p>";
                        }
                        elseif ($orderCheck == "SQL-statement-failed") {
                            echo "<p id='message' class='text-danger space-left'>Server error.</p>";
                        }
                    }
                ?>

            </div><!-- / checkout-form -->

            <div class="col-sm-4 checkout-total">
                <h4>Cart Total: <span class="total">$0</span></h4>
                <p>Subtotal: <span class="subtotal">$0</span></p>
                <p>Estimated tax: <span class="estimatedTax">$0</span></p>
                <p>Shipping: <span class="shipping">$0</span></p>

                
                <div class="cart-total-footer">
                    <a href="shopping-cart.php" class="btn btn-default-filled btn-rounded"><i class="lnr lnr-arrow-left"></i><span>Back to Cart</span></a>
                    <a href="./#categories" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-cart"></i><span>Back to Shop</span></a>
                </div><!-- / cart-total-footer -->
            </div><!-- / checkout-total -->

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

<!-- checkout -->
<script src="js/checkout.js"></script>
<!-- / checkout -->

<!-- cart -->
<script src="js/cart.js"></script>
<!-- / cart -->

<!-- / javascript -->
</body>

</html>