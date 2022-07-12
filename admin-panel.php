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
        <form action="./includes/product-management.inc.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <p>Main category type: </p>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Doorbells" id="addDoorbells">
                        <label for="addDoorbells">Doorbells</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Artwork" id="addArtwork">
                        <label for="addArtwork">Artwork</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Miscellaneous" id="addMiscellaneous">
                        <label for="addMiscellaneous">Miscellaneous</label>
                    <fieldset>
                </div>
                <div class="col-sm-6">
                    <label for="image">Image:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
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
                <div class="col-sm-6">
                    <input type="checkbox" name="addActive" id="addActive" value="1" checked>
                    <label for="addActive">Active item?</label>
                </div>
                <div class="col-sm-6">
                    <input type="checkbox" name="addFeatured" id="addFeatured" value="1">
                    <label for="addFeatured">Featured item?</label>
                </div>
                
            </div>
            <div class="row">
                <button type="submit" name="addProduct" id="add-submit" class="btn btn-primary-filled btn-rounded">Add Product</button>

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
                        elseif ($addProductCheck == "imageError") {
                            echo "<p class='error'>Image upload error. Please try again.</p>";
                        }
                        elseif ($addProductCheck == "success") {
                            echo "<p class='success'>Product added successfully.</p>";
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
                <button type="submit" name="deleteProduct" id="delete-submit" class="btn btn-md btn-primary-filled btn-form-submit btn-rounded">Delete Product</button>
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
                            echo "<p class='success'>Product deleted successfully.</p>";
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

<div class="form-container">
    <!-- edit product form -->
    <div id="select-product">
        <div class="col-sm-6">
            <label for="selectProductName">Name of product to edit:</label>
            <input type="text" class="form-control" name="selectProductName" placeholder="Product name" id="selectProductName">
        </div>
        <div class="row">
            <button name="selectProduct" id="selectProduct" class="btn btn-primary-filled btn-rounded">Select Product</button>

            <p id="select-product-error" hidden></p>   
        </div>
    </div>
    <div id="table-container">
        <table>
            <tr>
                    <th>Product Name</th>
                    <th>Main Category</th>
                    <th>Subcategories</th>
                    <th>Price</th>
                    <th>Shipping</th>
                    <th>Dimensions</th>
                    <th>Image Url</th>
                    <th>Active Status</th>
            </tr>
            <tr class="table-data"></tr>
        </table>
    </div>
    <?php 
    if (isset($_GET['editProduct'])) {
        echo '<div id="edit-product">';
    } else {
        echo '<div id="edit-product" hidden >';
    }
    ?>
        <h3>Please make your changes below:</h3>
        <form action="./includes/product-management.inc.php" method="POST" enctype="multipart/form-data" id="edit-form">
            <div class="row">
                <input type="hidden" name="originalProductName" id ="originalProductName" value="">
                <div class="col-sm-6">
                    <p>Main category type: </p>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Doorbells" id="editDoorbells">
                        <label for="editDoorbells">Doorbells</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Artwork" id="editArtwork">
                        <label for="editArtwork">Artwork</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Miscellaneous" id="editMiscellaneous">
                        <label for="editMiscellaneous">Miscellaneous</label>
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
                    <label for="newNameString">New product name:</label>
                    <input type="text" class="form-control" name="newNameString" placeholder="New product name" id="newNameString">
                </div>
                <div class="col-sm-6">
                    <label for="dimensions">Dimensions:</label>
                    <input type="text" class="form-control" name="dimensions" placeholder="Dimensions" id="dimensions">
                </div>
                <div class="col-sm-6">
                    <input type="checkbox" name="editActive" id="editActive" value="1" checked>
                    <label for="editActive">Active item?</label>
                </div>
                <div class="col-sm-6">
                    <input type="checkbox" name="editFeatured" id="editFeatured" value="1">
                    <label for="editFeatured">Featured item?</label>
                </div>
                <div class="row">
                    <button type="submit" name="editProduct" id="edit-submit" class="btn btn-primary-filled btn-rounded">Submit Edit</button>
                </div>
            </div>

            <!-- Server side form validation notifications. -->
            <?php
                if (!isset($_GET['editProduct'])) {
                    //do nothing
                }
                else {
                    $editProductCheck = $_GET['editProduct'];

                    if ($editProductCheck == "query") {
                        echo "<p class='error'>There was a database error. Please try again.</p>";
                        if (isset($_GET['code'])) {
                            echo "<p>Error: " . $_GET['code'] . "</p>";
                        }
                    }
                    elseif ($editProductCheck == "empty") {
                        echo "<p class='error'>Please fill out all required fields.</p>";
                    }
                    elseif ($editProductCheck == "error") {
                        echo "<p class='error'>Form submission error. Please try again.</p>";
                    }
                    elseif ($editProductCheck == "success") {
                        echo "<p class='success'>Product edited successfully.</p>";
                    }
                }
            ?>
            
        </form>
    </div><!-- / edit product form -->
</div><!-- / form-container -->

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

<!-- ajax -->
<script src="js/ajax.js"></script>
<!-- / ajax -->

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