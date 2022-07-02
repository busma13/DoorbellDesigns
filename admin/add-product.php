<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Doorbell Designs">
<meta name="keywords" content="doorbell, ceramic, hand-made" />
<meta name="author" content="Peter Luitjens">

<!-- favicon -->
<link rel="icon" href="images/favicon.png">
<!-- page title -->
<title>Doorbell Designs - Add Product</title>
<!-- bootstrap css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- css -->
<link href="css/style.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/owl.theme.css" rel="stylesheet">
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
                <a class="navbar-brand" href="index.html"><img src="images/logo-dd.jpg" alt=""></a>
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                        <ul class="dropdown-menu pulse animated">
                            <li><a href="doorbells.php">Doorbells</a></li>
                            <li><a href="artwork.html">Artwork</a></li>
                            <li><a href="fan-pulls.html">Ceiling Fan Pulls</a></li>
                            <li><a href="air-plant-holders.html">Air Plant Holders</a></li>
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
                    <li><a href="shopping-cart.html"><i class="lnr lnr-cart"></i> <span>Shopping Cart (<span class="cartCount">0</span>)</span></a></li>
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
<footer class="light-footer">
    <div class="widget-area">
        <div class="container">
            <div class="row">

                <!--<div class="col-sm-6 col-md-4 widget">
                    <div class="about-widget">
                        <div class="widget-title-image">
                            <img src="images/logo.png" alt="">
                        </div>
                        <p>Praesent sed congue ipsum. Nullam tempus ornare est, non aliquet velit tincidunt elementum. Nulla at risus ut felis eleifend. Nulla non lacinia. Integer est lacus, ultricies sed feugiat id, maximus nec.</p>
                    </div><!-- / about-widget -->
                <!--</div><!-- / widget -->
                

                <div class="col-sm-6 col-md-2 widget">
                    <div class="widget-title">
                        <h4>Doorbells</h4>
                    </div>
                    <div class="link-widget">
                        <div class="info">
                            <a href="doorbells.php">All</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=beachy">Beachy</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=contemporary">Contemporary</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=dog">Dog Lovers</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=animals">Animals</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=petroglyphs">Petroglyph</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=plants">Plants</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=southwest">Southwest</a>
                        </div>
                        <div class="info">
                            <a href="doorbells.php?category=misc">Miscellaneous</a>
                        </div>
                    </div>
                </div><!-- / widget -->
                <!-- / first widget -->
                <div class="col-sm-6 col-md-2 widget">
                    <div class="widget-title">
                        <h4>Miscellaneous</h4>
                    </div>
                    <div class="link-widget">
                        <div class="info">
                            <a href="art.html">Artwork</a>
                        </div>
                        <div class="info">
                            <a href="fan-pulls.html">Ceiling Fan Pulls</a>
                        </div>
                        <div class="info">
                            <a href="air-plant-holders.html">Air Plant Holders</a>
                        </div>
                        <div class="info">
                            <a href="custom-orders.html">Custom Orders</a>
                        </div>
                        <!-- <div class="info">
                            <a href="#x">Animals</a>
                        </div>
                        
                        <div class="info">
                            <a href="#x">Plants</a>
                        </div>
                        <div class="info">
                            <a href="#x">Traditional</a>
                        </div> -->
                    </div>
                </div><!-- / widget -->
                <!-- / second widget -->

                <div class="col-sm-6 col-md-2 widget">
                    <div class="widget-title">
                        <h4>Support</h4>
                    </div>
                    <div class="link-widget">
                        <div class="info">
                            <a href="instructions.html">Instructions</a>
                        </div>
                        <!-- <div class="info">
                            <a href="#x">Shipping & Return</a>
                        </div> -->
                        <div class="info">
                            <a href="faq.html">F.A.Q</a>
                        </div>
                        <div class="info">
                            <a href="schedule.html">Show Schedule</a>
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
                            <p><i class="lnr lnr-map-marker"></i><span>11885 Rocoso Road<br> Lakeside, CA 92040-1035</span></p>
                        </div>
                        <div class="info">
                            <a href="tel:6194671176"><i class="lnr lnr-phone-handset"></i><span>619-467-1176</span></a>
                        </div>
                        <div class="info">
                            <a href="mailto:info@cicadaceramics.com"><i class="lnr lnr-envelope"></i><span>info@cicadaceramics.com</span></a>
                        </div>
                        <!-- <div class="info">
                            <p class="social pull-left">
                                <a class="no-margin" href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                            </p>
                        </div> -->
                    </div><!-- / contact-widget -->
                </div><!-- / widget -->
                <!-- / fourth widget -->

            </div><!-- / row -->
        </div><!-- / container -->
    </div><!-- / widget-area -->
    <div class="footer-info">
        <div class="container">
                <div class="pull-left">
                    <p>© 2022 - <strong>Cicada Ceramics</strong> </p>
                </div>
                <span class="pull-right">
                    <span>???</span>
                </span>
        </div><!-- / container -->
    </div><!-- / footer-info -->
</footer>
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