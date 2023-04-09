</title>
<!-- bootstrap css -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- css -->
<link href="css/style_v2.css" rel="stylesheet">
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

<?php if ($title === 'Doorbell Designs - Doorbells') { ?>
    <!-- preloader -->
    <div id="preloader">
    <div class="spinner spinner-round"></div>
    </div>
    <!-- / preloader -->
<?php } ?>

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
                <a href="shopping-cart.php" class="navbar-toggle collapsed"><i class="lnr lnr-cart"></i><span> (<span class="cartCount">0</span>)</span></a>
                <?php if ($title === 'Cicada Ceramics - Ceiling Fan Pulls' 
                       || $title === 'Cicada Ceramics - Air Plant Cradles') {
                    echo '<a class="navbar-brand" href="index.php"><img class="cicada-logo" src="images/logo-cc.jpeg" alt="Cicada Ceramics logo"></a>';
                } elseif ($title === 'Doorbell Designs' 
                       || $title === 'Doorbell Designs - Doorbells'){
                        echo '<a class="navbar-brand" href="index.php"><img class="doorbell-designs-logo hide-logo-small" src="images/logo-dd.jpg" alt="Doorbell Designs logo"></a>';
                } else {
                    echo '<a class="navbar-brand" href="index.php"><img class="doorbell-designs-logo" src="images/logo-dd.jpg" alt="Doorbell Designs logo"></a>';
                } ?>
                
            </div><!-- / navbar-header -->
            <div class="navbar-collapse collapse">
                <div class="flex justify-center">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                            <ul class="dropdown-menu pulse animated">
                                <li><a href="doorbells.php?category=all">Doorbells</a></li>
                                <li><a href="fan-pulls.php">Ceiling Fan Pulls</a></li>
                                <li><a href="air-plant-cradles.php">Air Plant Cradles</a></li>
                                <li><a href="custom-orders.php">Custom Orders</a></li>
                            </ul>
                        </li>
                        <li><a href="instructions.php">Instructions</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="schedule.php">Shows</a></li>
                        
                        <li><a href="shopping-cart.php"><i class="lnr lnr-cart"></i> <span>Cart (<span class="cartCount">0</span>)</span></a></li>
                    </ul>
                </div>
            </div><!--/ nav-collapse -->
        </div><!-- / container -->
    </nav><!-- / navbar -->
