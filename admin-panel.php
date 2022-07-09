<?php
    session_start();
    include_once './includes/dbh.inc.php';

    /* Include the Account class file */
    include './includes/account-class.php';

    /* Create a new Account object */
    $account = new Account();
    
    
    $login = FALSE;

    try
    {
        $login = $account->sessionLogin();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        die();
    }

    if ($login)
    {
        // echo 'Authentication successful.';
        // echo 'Account ID: ' . $account->getId() . '<br>';
        echo 'Logged in as: ' . $account->getName() . '<br>';
        ?>
            <form action="./includes/admin-login.inc.php" method="POST">
                <button type="submit" name="logout" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log out</button>
            </form>
        <?php
    

        include 'header-pt1.php';
        $title = 'Doorbell Designs Admin - Admin Panel';
        echo $title;
        include 'header-pt2.php';
?>

    <!-- <div id="page-header" class=""> -->
        <div class="container">
            <div class="page-header-content text-center">
                <div class="page-header wsub">
                    <h1 class="page-title fadeInDown animated first">Admin Panel</h1>
                </div><!-- / page-header -->
                <!-- <p class="slide-text fadeInUp animated second">Fill out this form to add a new product to your website</p> -->
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    <!-- </div>/ page-header -->

</header>
<!-- / header -->

<!-- content -->

<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Add Product</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Fill out this form to add a new product to your website</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->

<div class="form-container">
    <!-- add product form -->
    <div id="add-form">
        <form action="./includes/product-management.inc.php" method="POST">
            <div class="row">
                <div class="col-sm-6">
                    <p>Main category type: </p>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Doorbells" id="doorbells">
                        <label for="doorbells">Doorbells</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Artwork" id="artwork">
                        <label for="artwork">Artwork</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Miscellaneous" id="miscellaneous">
                        <label for="miscellaneous">Miscellaneous</label>
                    <fieldset>
                </div>
                <div class="col-sm-6">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control" name="image" placeholder="Image" id="image">
                </div>
                <div class="col-sm-6">
                    <label for="price">Price (xx.xx format):</label>
                    <input type="number" step="0.01" class="form-control" name="price" placeholder="Price" id="price">
                </div>
                <div class="col-sm-6">
                    <label for="subCategories">Subcategories:</label>
                    <input type="text" class="form-control" name="subCategories" placeholder="subcategories" id="subCategories">
                </div>
                
                <div class="col-sm-6">
                    <label for="shipping">Shipping (xx.xx format):</label>
                    <input type="number" step="0.01" class="form-control" name="shipping" placeholder="Shipping" id="shipping">
                </div>
                <div class="col-sm-6">
                    <label for="itemNameString">Item name:</label>
                    <input type="text" class="form-control" name="itemNameString" placeholder="New item name" id="itemNameString">
                </div>
                <div class="col-sm-6">
                    <label for="dimensions">Dimensions:</label>
                    <input type="text" class="form-control" name="dimensions" placeholder="Dimensions" id="dimensions">
                </div>
                
            </div>
            <div class="row">
                <button type="submit" name="addProduct" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Add Product</button>

                 <!-- Server side form validation notifications. -->
                 <?php
                    if (!isset($_GET['addProduct'])) {
                        //do nothing
                    }
                    else {
                        $addProductCheck = $_GET['addProduct'];

                        if ($addProductCheck == "query") {
                            echo "<p class='error'>There was a database error. Please try again.</p>";
                            if (isset($_GET['code'])) {
                                echo "<p>Error: " . $_GET['code'] . "</p>";
                            }
                        }
                        elseif ($addProductCheck == "empty") {
                            echo "<p class='error'>Please fill out the form completely.</p>";
                        }
                        elseif ($addProductCheck == "error") {
                            echo "<p class='error'>Form submission error. Please try again.</p>";
                        }
                        elseif ($addProductCheck == "success") {
                            echo "<p class='success'>Product added Successfully.</p>";
                        }
                    }
                ?>
                
            </div>
        </form>
    </div><!-- / add product form -->
</div><!-- / form-container -->

<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Delete Product</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Fill out this form to delete a product</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->

<div class="form-container">
    <!-- delete form -->
    <div id="delete-form">
        <form action="./includes/product-management.inc.php" method="POST">
            <div class="col-sm-6">
                <label for="deleteName">Product name:</label>
                <input type="text" name="deleteProductName" class="form-control" id="deleteName" placeholder="Product name" required>
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-sm-6">
                <button type="submit" name="delete" id="delete-submit" class="btn btn-md btn-primary-filled btn-form-submit btn-rounded">Delete Product</button>
            </div>
            <div id="msgSubmit" class="h3 text-center hidden"></div>
            <div class="clearfix"></div>  

            <!-- Server side form validation notifications. -->
            <?php
                    if (!isset($_GET['deleteProduct'])) {
                        //do nothing
                    }
                    else {
                        $deleteProductCheck = $_GET['deleteProduct'];

                        if ($deleteProductCheck == "query") {
                            echo "<p class='error'>There was a database error. Please try again.</p>";
                            if (isset($_GET['code'])) {
                                echo "<p>Error: " . $_GET['code'] . "</p>";
                            }
                        }
                        elseif ($deleteProductCheck == "empty") {
                            echo "<p class='error'>Please fill out the form completely.</p>";
                        }
                        elseif ($deleteProductCheck == "error") {
                            echo "<p class='error'>Form submission error. Please try again.</p>";
                        }
                        elseif ($deleteProductCheck == "fail") {
                            echo "<p class='error'>The delete operation failed. Try again.</p>";
                            //Product not found. Check your spelling.
                        }
                        elseif ($deleteProductCheck == "success") {
                            echo "<p class='success'>Product deleted Successfully.</p>";
                        }
                    }
                ?>
        </form>
    </div><!-- / delete form -->
</div><!-- / form-container -->


<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Edit Product</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Fill out this form to edit a product</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->



<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Edit Show Schedule</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Fill out this form to edit the show schedule</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->

<div class="form-container">
    <h4 class="space-left">Checkout</h4>
    <form action="./includes/order.inc.php" method="POST">
        <div class="row">
            <div class="col-sm-6">
                <label for="test">Image:</label>
                <input type="text" id="test" class="form-control" name="first-name" placeholder="*First name" required>
                <input type="text" class="form-control" name="last-name" placeholder="*Last name" required>
                
                
            </div>
            <div class="col-sm-6">
                <input type="tel" class="form-control" name="tel" placeholder="*Phone" required>
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

<!-- scrolling-nav -->
<script src="js/scrolling-nav.js"></script>
<!-- / scrolling-nav -->

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
<?php
    }
    else
    {
        header("Location: ./admin.php");
    }
?>