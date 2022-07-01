<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - About';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="about">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">About</h1>
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
                <h3>About the Shop</h3>
            </div><!-- / page-header -->
            <p class="large-p">Welcome</p>
            <p>
                Yay! We are once more doing shows. Fully vaccinated and ready to go. Hope to see you soon!
            </p>
            <p>    
                We are Ray and Colleen Dossey. We make decorative ceramic doorbells to enhance the entrance to your home. Everything is made right here at home in the USA. This ceramic artwork is only available online here or at Arts & Crafts Shows.
            </p>
            <p>    
                You may also order doorbells custom made especially for you. All the colors we use are fired on underglazes and glazes and will not fade in the sun or be damaged by rain.
            </p>
            <p>    
                All our door bells come with lighted buttons, screws and anchors, and instructions. They are for wired doorbells. They can replace any shape of wired door bell button. We can also make a decorative door bell surround for your wireless doorbell button.
            </p>
            <p>    
                 We primarily do shows in the Southwest and Florida (<a href="schedule.html">Show Schedule</a>).  Although we have sold hundreds of doorbells to people throughout the US, Canada, the UK and Australia.
            </p>
            <div class="page-header text-center space-top-30">
                <h3>There are a few things you do need to know:</h3>
            </div><!-- / page-header -->    
                
            <ul>
                <li>Where is your doorbell? I know it seems like an odd question, but we can't tell you how many times people tell us they can't remember where their doorbell is because they've never rung it!</li>
                <li>Is it close to, or on the door frame?</li>
                <li>How close?</li>
                <li>Close to a corner or the edge of the wall?</li>
                <li>Will it be attached to stucco, cement block, or an electrical box?</li>
                <li>Will it be attached to wood siding, 4", 6", or 8"?</li>
                <li>If so, where is your button in relation to that siding, in the middle, near the top, or bottom?</li>
                <li>Are you replacing a non-functioning intercom?</li>
                <li>Are you trying to cover the place where the builder messed up the stucco when he repaired the doorbell?</li>
                <li>How big can it be?</li>
                <li>How small does it have to be?</li>
            </ul>
            <p>
                Fortunately, all you have to do is go take a look to answer all these questions. So go take a look and come back and choose your perfect doorbell!
            </p>
            <p>     
                Our doorbells are all handmade so sizes are only approximate. If you need a particular length or width please let us know when you order.
            </p>
            <p>     
                Be sure to e-mail us with your order before you pay through Square, so that we can determine if we have what you want in stock. We usually send an email with choices of what we have available in the design you order. Especially, if we don't have one very similar to the picture on our site. Everything we make is created one at a time, so many designs are similar, but not identical to the ones pictured here. Also glazes change and get discontinued and so colors may vary. If you have any questions, give us a call (<span>619 467-1176</span>) or email. <span>info@cicadaceramics.com</span>
            </p>
             
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