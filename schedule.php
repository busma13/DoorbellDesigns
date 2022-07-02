<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Schedule';
    echo $title;
    include 'header-pt2.php';
?>


    <div id="page-header" class="about">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Schedule</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second">Your page's description goes here...</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<!-- content -->

<!-- about -->
<section id="about">
    <div class="container">
        <div class="text-wrap">
            <div class="page-header text-center space-top-30">
                <h3>Show Schedule</h3>
            </div><!-- / page-header -->
            <div class="show-header">
                <h2 class="show-date">Date</h2>
                <h2 class="show-name">Name</h2>
                <h2 class="show-location">Location</h2>
            </div>
            <div class="show">
                <time datetime="2022-06-26">June 26, 2022</time>
                <span>Carlsbad Art in the Village</span>
                <span>Carlsbad, CA</span>
            </div>
            <span>* Denotes confirmed show</span>
            
             
        </div><!-- / text-wrap -->   
    </div><!-- / container -->
</section>
<!-- / about -->




<!-- / about -->

<!-- / content -->

<?php
    include 'footer.php';
?>

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- sliders -->
<script src="js/owl.carousel.min.js"></script>
<!-- brands carousel -->
<script>
    $(document).ready(function() {
      $("#brands-carousel").owlCarousel({
        autoPlay: 5000, //set autoPlay to 5 seconds.
        items : 5,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
      });

    });
</script>
<!-- / brands carousel -->
<!-- / sliders -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>