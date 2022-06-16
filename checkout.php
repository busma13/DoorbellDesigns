<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Responsive Shop Theme">
<meta name="keywords" content="responsive, retina ready, shop bootstrap template, html5, css3" />
<meta name="author" content="KingStudio.ro">

<!-- favicon -->
<link rel="icon" href="images/favicon.png">
<!-- page title -->
<title>inCart - Responsive Shop Theme</title>
<!-- bootstrap css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- css -->
<link href="css/style.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<!-- fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='fonts/FontAwesome.otf' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/linear-icons.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<!-- preloader -->
<div id="preloader">
    <div class="spinner spinner-round"></div>
</div>
<!-- / preloader -->

<!-- header -->
<header>
    <!-- https://connect.squareup.com/v2/checkout?c={{CHECKOUT_ID}}&l={{LOCATION_ID}}
 -->
    <div class="top-menu top-menu-inverse">
        <!-- <div class="container">
            <p>
                <span class="left">Free Worldwide shipping on orders over <span class="text-primary"><strong>$100</strong></span>!</span>
                <span class="right">
                    <a href="my-account.html"><i class="lnr lnr-user"></i> <span>My Account</span></a>
                    <a href="login-register.html"><i class="lnr lnr-lock"></i> <span>Login / Register</span></a>
                    <a href="shopping-cart.html"><i class="lnr lnr-cart"></i> <span>Shopping Cart (2)</span></a>
                </span>
            </p>
        </div>/ container -->
    </div><!-- / top-menu-inverse -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt=""></a>
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                        <ul class="dropdown-menu pulse animated">
                            <li><a href="shop-filter.html">All Products</a></li>
                            <li><a href="shop-filter.html#doorbells">Doorbells</a></li>
                            <li><a href="shop-filter.html">Ceiling Fan Pulls</a></li>
                            <li><a href="shop-filter.html#artwork">Artwork</a></li>
                            <li><a href="custom-orders.html">Custom Orders</a></li>
                            <li><a href="shopping-cart.html">Shopping Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                        </ul>
                    </li>
                    <li><a href="instructions.html">Instructions</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="about.html">About</a></li>
                    <!-- <li><a href="blog.html">Blog</a></li> -->
                    <li><a href="contact.html">Contact</a></li>
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages <span class="caret"></span></a>
                        <ul class="dropdown-menu pulse animated">
                            <li><a href="login-register.html">Login / Register</a></li>
                            <li><a href="my-account.html">My Account</a></li>
                            <li><a href="single-post.html">Single Post</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="404.html">404 Page</a></li>
                            <li><a href="components.html">Components</a></li>
                        </ul>
                    </li> -->
                    <li><a href="shopping-cart.html"><i class="lnr lnr-cart"></i> <span>Shopping Cart (2)</span></a></li>
                    <!-- <li class="dropdown w-image">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/eng.png" alt=""> <span class="caret"></span></a>
                        <ul class="dropdown-menu pulse animated">
                            <li><a href="#"><img src="images/fr.png" alt=""> FR</a></li>
                            <li><a href="#"><img src="images/de.png" alt=""> DE</a></li>
                            <li><a href="#"><img src="images/es.png" alt=""> ES</a></li>
                        </ul>
                    </li>     -->
                </ul>
            </div><!--/ nav-collapse -->
        </div><!-- / container -->
    </nav><!-- / navbar -->

    <div id="page-header" class="checkout">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Checkout</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second">Page description goes here...</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<!-- content -->

<!-- shopping-cart -->
<div id="checkout">
    <div class="container">
        <div class="row checkout-screen">
            <div class="col-sm-8 checkout-form">
                <h4 class="space-left">Checkout</h4>
                <!-- <p class="space-left have-account">Already have an account? <a href="login-register.html" class="btn btn-link"><i class="lnr lnr-enter"></i><span>Login</span></a></p> -->
                <!-- <form onsubmit="return sendData()" id="orderForm"> -->
                <form action="./includes/order.inc.php" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="first-name" placeholder="*First name" required>
                            <input type="text" class="form-control" name="last-name" placeholder="*Last name" required>
                            
                            
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control" name="tel" placeholder="Phone" required>
                            <input type="email" class="form-control" name="email" placeholder="*Email" required>
                            <!-- <input type="text" class="form-control" name="company" placeholder="Company"> -->
                            
                        </div>
                    </div><!-- / row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="address-line" placeholder="*Address Line" required>
                            <select class="form-control" name="state" required>
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

                    <input type="hidden" name="cart-products" value="test">

                    <div class="checkout-form-footer space-left space-right">
                        <!-- <textarea class="form-control" name="message" placeholder="Message" required></textarea> -->
                        <!-- <a href="" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-exit"></i><span>Checkout with Square</span></a> -->
                        <button type="submit" name="submit" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-exit"></i><span>Checkout with Square</span></button>
                    </div><!-- / checkout-form-footer -->
                </form>

            
                <!-- Server side form validation notifications. -->
                <?php
                    if (!isset($_GET['order'])) {
                        //do nothing
                    }
                    else {
                        $orderCheck = $_GET['order'];
                        // echo $orderCheck;
                        if ($orderCheck == "empty") {
                            echo "<p class='error'>Please fill out all required fields.</p>";
                            // exit();
                        }
                        elseif ($orderCheck == "email") {
                            echo "<p class='error'>Please enter a valid email.</p>";
                            // exit();
                        }
                        elseif ($orderCheck == "error") {
                            echo "<p class='error'>Form submission error. Please try again.</p>";
                            // exit();
                        }
                        elseif ($orderCheck == "success") {
                            echo "<p class='success'>Order submitted.</p>";
                            // exit();
                        }
                    }
                ?>

            </div><!-- / checkout-form -->

            <div class="col-sm-4 checkout-total">
                <h4>Cart Total: <span class="total">$0</span></h4>
                <p>Subtotal: <span class="subtotal">$0</span></p>
                <p>Shipping: <span class="shipping">$0</span></p>

                
                <div class="cart-total-footer">
                    <a href="shopping-cart.html" class="btn btn-default-filled btn-rounded"><i class="lnr lnr-arrow-left"></i><span>Back to Cart</span></a>
                    <a href="./#categories" class="btn btn-primary-filled btn-rounded"><i class="lnr lnr-cart"></i><span>Back to Shop</span></a>
                </div><!-- / cart-total-footer -->
            </div><!-- / checkout-total -->

        </div><!-- / row -->
    </div><!-- / container -->
</div>
<!-- / shopping-cart -->

<!-- / content -->

<!-- footer -->
<footer class="light-footer">
    <div class="widget-area">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-md-4 widget">
                    <div class="about-widget">
                        <div class="widget-title-image">
                            <img src="images/logo.png" alt="">
                        </div>
                        <p>Praesent sed congue ipsum. Nullam tempus ornare est, non aliquet velit tincidunt elementum. Nulla at risus ut felis eleifend. Nulla non lacinia. Integer est lacus, ultricies sed feugiat id, maximus nec.</p>
                    </div><!-- / about-widget -->
                </div><!-- / widget -->
                <!-- / first widget -->

                <div class="col-sm-6 col-md-2 widget">
                    <div class="widget-title">
                        <h4>Brands</h4>
                    </div>
                    <div class="link-widget">
                        <div class="info">
                            <a href="#x">Marco REA</a>
                        </div>
                        <div class="info">
                            <a href="#x">3Days</a>
                        </div>
                        <div class="info">
                            <a href="#x">La Barcelona</a>
                        </div>
                        <div class="info">
                            <a href="#x">Lora Towers</a>
                        </div>
                        <div class="info">
                            <a href="#x">Ginneys</a>
                        </div>
                    </div>
                </div><!-- / widget -->
                <!-- / second widget -->

                <div class="col-sm-6 col-md-2 widget">
                    <div class="widget-title">
                        <h4>Support</h4>
                    </div>
                    <div class="link-widget">
                        <div class="info">
                            <a href="#x">Privacy Policy</a>
                        </div>
                        <div class="info">
                            <a href="#x">Shipping & Return</a>
                        </div>
                        <div class="info">
                            <a href="#x">Terms & Conditions</a>
                        </div>
                        <div class="info">
                            <a href="faq.html">F.A.Q</a>
                        </div>
                        <div class="info">
                            <a href="contact.html">Contact</a>
                        </div>
                    </div>
                </div><!-- / widget -->
                <!-- / third widget -->

                <div class="col-sm-6 col-md-4 widget">
                    <div class="widget-title">
                        <h4>Get in Touch</h4>
                    </div>
                    <div class="contact-widget">
                        <div class="info">
                            <p><i class="lnr lnr-map-marker"></i><span>Miami, S Miami Ave, SW 20th.</span></p>
                        </div>
                        <div class="info">
                            <a href="tel:+0123456789"><i class="lnr lnr-phone-handset"></i><span>+0123 456 789</span></a>
                        </div>
                        <div class="info">
                            <a href="mailto:hello@yoursite.com"><i class="lnr lnr-envelope"></i><span>office@yoursite.com</span></a>
                        </div>
                        <div class="info">
                            <p class="social pull-left">
                                <a class="no-margin" href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                            </p>
                        </div>
                    </div><!-- / contact-widget -->
                </div><!-- / widget -->
                <!-- / fourth widget -->

            </div><!-- / row -->
        </div><!-- / container -->
    </div><!-- / widget-area -->
    <div class="footer-info">
        <div class="container">
                <div class="pull-left">
                    <p>© 2016 - <strong>inCart</strong> - Responsive Shop Theme.</p>
                </div>
                <span class="pull-right">
                    <img src="images/visa.png" alt="">
                    <img src="images/mastercard.png" alt="">
                    <img src="images/discover.png" alt="">
                    <img src="images/paypal.png" alt="">
                </span>
        </div><!-- / container -->
    </div><!-- / footer-info -->
</footer>
<!-- / footer -->

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- checkout -->
<script src="js/checkout.js"></script>
<!-- / checkout -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>