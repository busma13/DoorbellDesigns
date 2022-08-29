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
<hr>

<!-- <button class="trigger">Click here to trigger the modal!</button>
<div class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h1>Hello, I am a modal!</h1>
    </div>
</div> -->

<!-- Modal for confirming a product delete -->
<div id="deleteConfProduct" class="modal">
    <span onclick="document.getElementById('deleteConfProduct').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="modal-content">
        <h1>Delete Product</h1>
        <p>Are you sure you want to delete this product?</p>

        <div class="flex-container modal-button-container">
        <button type="button" class="btn btn-rounded btn-info btn-modal btn-cancel">Cancel</button>
        <button type="button" class="btn btn-rounded btn-danger btn-modal" id="btn-delete-product" data-id="0">Delete</button>
        </div>
    </div>
</div>

<!-- Modal for confirming a show delete -->
<div id="deleteConfShow" class="modal">
    <span onclick="document.getElementById('deleteConfShow').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="modal-content">
        <h1>Delete Show</h1>
        <p>Are you sure you want to delete this show?</p>

        <div class="flex-container modal-button-container">
        <button type="button" class="btn btn-rounded btn-info btn-modal btn-cancel">Cancel</button>
        <button type="button" class="btn btn-rounded btn-danger btn-modal" id="btn-delete-show" data-id="0">Delete</button>
        </div>
    </div>
</div>
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
        <form action="./includes/add-product.inc.php" method="POST" enctype="multipart/form-data">
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
                        <input type="radio" name="mainCategory" value="Fan-Pulls" id="addCeilingFanPulls">
                        <label for="addCeilingFanPulls">Ceiling Fan Pulls</label>
                    </fieldset>
                    <fieldset>
                        <input type="radio" name="mainCategory" value="Air-Plant-Holders" id="addAirPlantHolders">
                        <label for="addAirPlantHolders">Air Plant Holders</label>
                    </fieldset>
                    <!-- <fieldset>
                        <input type="radio" name="mainCategory" value="Miscellaneous" id="addMiscellaneous">
                        <label for="addMiscellaneous">Miscellaneous</label>
                    </fieldset> -->
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
                    <label for="baseColorOptions">Base Color Options:</label>
                    <input type="text" class="form-control" name="baseColorOptions" placeholder="Base Color Options" id="baseColorOptions">
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
                        elseif ($addProductCheck == "imageResizeError") {
                            echo "<p class='error'>Image resize error. Please try again.</p>";
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

<hr>

<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Edit Products</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Double click to edit a product value.</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->

<!-- editable product table -->
<div class="container full-width">
    <div id="product-table-container">
        <table class="editable">
            <tbody id="product-table-body"> 
                <tr>
                    <th></th>
                    <th></th>
                    <th><span>Image Url</span></th>
                    <th>Product Name</th>
                    <th>Main Category</th>
                    <th>Subcategories</th>
                    <th>Price</th>
                    <th>Shipping</th>
                    <th>Base color options</th>
                    <th>Dimensions</th>
                    <th>Active Status</th>
                    <th>Featured Status</th>
                </tr>
<?php
$get_products_sql = "SELECT * FROM products ORDER BY itemNameString;";

/* Execute the query */
try
{
    $res = $pdo->prepare($get_products_sql);
    $res->execute();
}
catch (PDOException $e)
{
/* If there is a PDO exception, throw a standard exception */
throw new Exception('Database query error');
}
while ($row = $res->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr id="<?php echo $row['id']?>">
                    <td><button class="deleteProductButton"><i class="lnr lnr-trash"></i></button></td>
                    <td class="img"><img src="images/<?php echo strtolower($row['mainCategory']) . '-small/' . $row['imgUrl'] ?>"></td>
                    <td class="imgUrl break-word"><?php echo $row['imgUrl']?></td>
                    <td class="itemNameString"><?php echo $row['itemNameString']?></td>
                    <td class="mainCategory"><?php echo $row['mainCategory']?></td>
                    <td class="subCategories"><?php echo $row['subCategories']?></td>
                    <td class="price"><?php echo $row['price']?></td>
                    <td class="shipping"><?php echo $row['shipping']?></td>
                    <td class="baseColor"><?php echo $row['baseColor']?></td>
                    <td class="dimensions"><?php echo $row['dimensions']?></td>
                    <td class="active"><?php echo $row['active']?></td>
                    <td class="featured"><?php echo $row['featured']?></td>
                </tr>
<?php
}
?>
            </tbody>
        </table>
    </div>
    <p class="responseMessageProduct"></p>


</div><!-- / editable product table -->

<hr>

<div class="container">
    <div class="page-header-content text-center">
        <div class="page-header wsub">
            <h1 class="page-title fadeInDown animated first">Edit Show Schedule</h1>
        </div><!-- / page-header -->
        <p class="slide-text fadeInUp animated second">Double click a date, name, or location to edit the content.  Click a trashcan to delete the whole show. Click the Add Show button to add a new row.</p>
    </div><!-- / page-header-content -->
</div><!-- / container -->

<div class="container">
    <h4 class="space-left">Current Schedule:</h4>
    <div id="show-table-container">
        <table class="editable">
            <tbody id="show-table-body"> 
                <tr>
                    <th></th>
                    <th class="show-date">Date</th>
                    <th class="show-name">Name</th>
                    <th class="show-location">Location</th>
                </tr>
            
<?php
$get_shows_sql = "SELECT * FROM shows ORDER BY date;";

/* Execute the query */
try
{
    $res = $pdo->prepare($get_shows_sql);
    $res->execute();
}
catch (PDOException $e)
{
/* If there is a PDO exception, throw a standard exception */
throw new Exception('Database query error');
}
while ($row = $res->fetch(PDO::FETCH_ASSOC)) { ?>
                    
                <tr id="<?php echo $row['date']?>">
                    <td><button class="deleteShowButton"><i class="lnr lnr-trash"></i></button></td>
                    <td class="scheduleDateString"><time><?php echo $row['dateString']?></time></td>
                    <td class="scheduleName"><?php echo $row['name']?></td>
                    <td class="scheduleLocation"><?php echo $row['location']?></td>
                </tr>
                
<?php
}
?>
            </tbody>
        </table>
    </div>
    <p id="responseMessageShow"></p>

    <button name="addShow" id="addShowButton" class="btn btn-primary-filled btn-rounded btn-edit-show">Add a Show</button>


</div><!-- / edit schedule -->

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

<!-- admin-panel -->
<script src="js/admin-panel.js"></script>
<!-- / admin-panel -->

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