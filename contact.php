<?php
    include_once 'includes/dbh.inc.php';
    include 'header-pt1.php';
    $title = 'Doorbell Designs - Contact';
    echo $title;
    include 'header-pt2.php';
?>

    <div id="page-header" class="contact">
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Contact</h1>
                </div><!-- / page-header -->
                <p class="slide-text fadeInUp animated second">Your page's description goes here...</p>
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->

</header>
<!-- / header -->

<!-- content -->

<!-- contact -->
<section id="contact">
    <div class="container">
        <div class="row">

            <div class="col-sm-6 contact-details">
                <h4>Email</h4>
                <p><a href="mailto:info@cicadaceramics.com">info@cicadaceramics.com</a></p>

                <h4 class="space-top">Phone</h4>
                <p><a href="tel:6194431872">619-443-1872</a></p>

                <h4 class="space-top">Cell</h4>
                <p><a href="tel:6193685314">619-368-5314</a></p>

                <h4 class="space-top">Mailing Address</h4>
                <address>
                    <p>Cicada Ceramics</p>
                    <p>11885 Rocoso Rd.</p>
                    <p>Lakeside, CA, 92040</p>
                </address>
                
            </div>

             <div class="col-sm-6 form-container">
                <!-- contact form -->
                <div id="contact-form-1">
                    <form id="contactForm" data-toggle="validator">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Full Name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <textarea id="message" class="form-control" rows="5" placeholder="Message" required></textarea>
                        <div class="help-block with-errors"></div>
                        </div>
                        <button type="submit" id="form-submit" class="btn btn-md btn-primary-filled btn-form-submit btn-rounded">Send Message</button>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>  
                    </form>
                </div><!-- / contact form -->
            </div><!-- / form-container -->
        </div><!-- / row -->
    </div><!-- / container -->
</section>
<!-- / contact -->

<!-- / content -->

<?php
    include 'footer.php';
?>

<!-- javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>

<!-- contact-form -->
<script src="js/validator.min.js" type="text/javascript"></script>
<script src="js/form-scripts.js" type="text/javascript"></script>
<!-- / contact-form -->

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>