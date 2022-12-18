</title>
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

</head>

<body>

<!-- preloader -->
<!-- <div id="preloader">
    <div class="spinner spinner-round"></div>
</div> -->
<!-- / preloader -->

<!-- header -->
<header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <?php if ($title === 'Cicada Ceramics - Ceiling Fan Pulls' || $title === 'Cicada Ceramics - Air Plant Cradles') {
                    echo '<a class="navbar-brand" href="index.php"><img class="cicada-logo" src="images/logo-cc.jpeg" alt="Cicada Ceramics logo"></a>';
                } else {
                    echo '<a class="navbar-brand" href="index.php"><img src="images/logo-dd.jpg" alt="Doorbell Designs logo"></a>';
                } ?>
                
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                        <ul class="dropdown-menu pulse animated">
                            <li><a href="doorbells.php">Doorbells</a></li>
                            <li><a href="fan-pulls.php">Ceiling Fan Pulls</a></li>
                            <li><a href="air-plant-cradles.php">Air Plant Cradles</a></li>
                            <li><a href="custom-orders.php">Custom Orders</a></li>
                            <li><a href="shopping-cart.php">Shopping Cart</a></li>
                            <li><a href="checkout.php">Checkout</a></li>
                        </ul>
                    </li>
                    <li><a href="instructions.php">Instructions</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="about.php">About</a></li>
                    <!-- <li><a href="blog.html">Blog</a></li> -->
                    <li><a href="contact.php">Contact</a></li>
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
                    <li><a href="shopping-cart.php"><i class="lnr lnr-cart"></i> <span>Shopping Cart (<span class="cartCount">0</span>)</span></a></li>
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
