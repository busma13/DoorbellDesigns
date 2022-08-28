<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Instructions';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="about">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Instructions</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second"></p>
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
                <h3>Doorbell Mounting Instructions</h3>
            </div><!-- / page-header -->
            <h4>Quick Instructions</h4>
            <ol>
                <li>Doorbells normally use about 12 volts of electricity, so there is no need to turn off the electricity.</li>
                <li>Remove the old doorbell.</li>
                <li>Make sure there is enough room for the back of the new button and wires to fit back into the hole. If not, use a file or utility knife to enlarge the hole.</li>
                <li>Align decorative plate with wire hole and mark screw holes.</li>
                <li>Pre-drill holes for screws in wood or siding, or for anchors (Use a 3/16 masonry bit to a depth of 7/8") in stucco or brick walls.</li>
                <li>Attach wire leads to screw terminals on button.</li>
                <li>Attach plate to wall with screws.</li>
            </ol>
            
            <h4 class="space-top-2x">Detailed Instructions</h4>
            <p>You will need a drill with the appropriate drill bit (1/8" bit for wood or a 3/16" masonry bit for stucco or brick), a screw driver, a hammer and maybe a utility knife.</p>
                    
            <p>Doorbells only use 9 to 14 volts of electricity, so you don't need to turn off the electricity.</p>
                
            <div class="inst-container">
                <p>First remove the old doorbell. If it is just a button, pry it out with a screwdriver. It is just held in by friction. If it is screwed on to the wall, remove the screws.</p><img class="inst-img" src="images/instructions/detach.JPG" alt="detach old doorbell">
            </div>
            <div class="inst-container">        
                <p>Detach the wire leads from the posts on the back of the button by loosening the small screws on either side.</p><img class="inst-img" src="images/instructions/disconnect.JPG" alt="disconnect wires">
            </div>
            <div class="inst-container">    
                <p>Remove the old doorbell.</p><img class="inst-img" src="images/instructions/remove.JPG" alt="remove old doorbell">
            </div>
            <div class="inst-container">
                <p>To mark the holes on the wall for your new doorbell surround, hold it up aligned with the old hole in the wall where the wires come out. Make sure it will fit back into the hole. If it won't use a utility knife to remove enough material so it will fit. Make sure you have it straight on the wall and mark the holes with a pencil or awl.</p><img class="inst-img" src="images/instructions/mark.JPG" alt="mark holes for new doorbell">
            </div>
            <div class="inst-container">
                <p>Using the appropriate bit (You really do need a masonry bit to drill into stucco or brick!), drill where you have marked the holes.</p><img class="inst-img" src="images/instructions/drill.JPG" alt="drill holes">
            </div>
            <div class="inst-container">  
                <p>Pound in the plastic anchors for stucco or brick.</p><img class="inst-img" src="images/instructions/anchors.JPG" alt="pound in anchors">
            </div>
            <div class="inst-container">
                <p>Attach a wire lead to each post on the back of the button. It does not matter which wire goes to which lead.</p><img class="inst-img" src="images/instructions/reattach2.JPG" alt="attach wires to button">
            </div>
            <div class="inst-container">
                <p>Put the button-back into the hole along with the excess wire and line up pilot holes you drilled for the wood screws or the anchors you put in for the stucco and screw in the screws. DO NOT OVER-TIGHTEN THE SCREWS!</p><img class="inst-img" src="images/instructions/screw1.JPG" alt="screw into wall">
            </div>        
            <div class="inst-container">
                <p>You're done!</p><img class="inst-img" src="images/instructions/done.JPG" alt="done">                    
            </div>
        </div>
    </div><!-- / container -->
</section>
<!-- / about -->

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