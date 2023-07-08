<?php
session_start();
include_once 'src/Dbh.php';

use App\AccountClass;

$account = new AccountClass();

$login = FALSE;

try {
  $login = $account->sessionLogin();
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

if ($login) {
  include 'header-pt1.php';
  $title = 'Doorbell Designs Admin - Admin Panel';
  echo $title;
  include 'header-pt2.php';
  // echo 'Authentication successful.';
  // echo 'Account ID: ' . $account->getId() . '<br>';
  echo 'Logged in as: ' . $account->getName() . '<br>';
  ?>
  <form action="./src/AdminLogin.php" method="POST">
    <button type="submit" name="logout" id="checkout-btn" class="btn btn-primary-filled btn-rounded">Log out</button>
  </form>


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

  <!-- Modal for confirming a product delete -->
  <div id="deleteConfProduct" class="modal">
    <span onclick="document.getElementById('deleteConfProduct').style.display='none'" class="close"
      title="Close Modal">&times;</span>
    <div class="modal-content">
      <h1>Delete Product</h1>
      <p>Are you sure you want to delete this product?</p>

      <div class="flex modal-button-container">
        <button type="button" class="btn btn-rounded btn-info btn-modal btn-cancel">Cancel</button>
        <button type="button" class="btn btn-rounded btn-danger btn-modal" id="btn-delete-product"
          data-id="0">Delete</button>
      </div>
    </div>
  </div>

  <!-- Modal for confirming a show delete -->
  <div id="deleteConfShow" class="modal">
    <span onclick="document.getElementById('deleteConfShow').style.display='none'" class="close"
      title="Close Modal">&times;</span>
    <div class="modal-content">
      <h1>Delete Show</h1>
      <p>Are you sure you want to delete this show?</p>

      <div class="flex modal-button-container">
        <button type="button" class="btn btn-rounded btn-info btn-modal btn-cancel">Cancel</button>
        <button type="button" class="btn btn-rounded btn-danger btn-modal" id="btn-delete-show"
          data-id="0">Delete</button>
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
      <form action="./src/AddProduct.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6 mt-15">
            <p>Main category type: </p>
            <fieldset>
              <input type="radio" name="mainCategory" value="Doorbells" id="addDoorbells">
              <label for="addDoorbells">Doorbells</label>
            </fieldset>
            <!-- <fieldset>
                        <input type="radio" name="mainCategory" value="Artwork" id="addArtwork">
                        <label for="addArtwork">Artwork</label>
                    </fieldset> -->
            <fieldset>
              <input type="radio" name="mainCategory" value="Fan-Pulls" id="addCeilingFanPulls">
              <label for="addCeilingFanPulls">Ceiling Fan Pulls</label>
            </fieldset>
            <fieldset>
              <input type="radio" name="mainCategory" value="Air-Plant-Cradles" id="addAirPlantCradles">
              <label for="addAirPlantCradles">Air Plant Cradles</label>
            </fieldset>
            <!-- <fieldset>
                        <input type="radio" name="mainCategory" value="Miscellaneous" id="addMiscellaneous">
                        <label for="addMiscellaneous">Miscellaneous</label>
                    </fieldset> -->
          </div>
          <!-- <div class="col-sm-6 mt-15">
                    <label for="image">Image:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <input type="file" class="form-control" name="image" placeholder="Image" id="image">
                </div> -->
          <div class="col-sm-6 mt-15">
            <label for="priceSingle">Price (xx.xx format):</label>
            <input type="number" step="0.01" class="form-control" name="priceSingle" placeholder="Price for 1"
              id="priceSingle">
          </div>
          <div class="col-sm-6 mt-15">
            <label for="pricePair">Price For A Pair (xx.xx format):</label>
            <input type="number" step="0.01" class="form-control" name="pricePair" placeholder="Price for 2"
              id="pricePair">
          </div>
          <div class="col-sm-6 mt-15">
            <label for="subCategories">Subcategories (comma separated):</label>
            <input type="text" class="form-control" name="subCategories" placeholder="subcategories" id="subCategories">
          </div>
          <div class="col-sm-6 mt-15">
            <label for="shipping">Shipping (xx.xx format):</label>
            <input type="number" step="0.01" class="form-control" name="shipping" placeholder="Shipping" id="shipping">
          </div>
          <div class="col-sm-6 mt-15">
            <label for="optionIDs">Option IDs (hold ctrl/cmd to select multiple):</label>
            <select class="form-control" name="optionIDs[]" id="optionIDs" multiple>
              <option value="">No Options</option>
              <?php
              $get_options_sql = "SELECT * FROM options ORDER BY name;";

              /* Execute the query */
              try {
                $res0 = $pdo->prepare($get_options_sql);
                $res0->execute();
              } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error');
              }
              while ($row = $res0->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] . ": " . $row['optionValues'] ?></option>
                <?php
              }
              ?>

              <option value="1">Base Color: ["Grey","Light Brown"]</option>
              <option value="2">Arrow Direction: ["Up","Down","Left","Right"]</option>
              <option value="3">Chain Color: ["Silver Tone","Brass Tone"]</option>
              <option value="4">Paw Color: ["Black","Blue","Brown"]</option>
              <option value="5">Combadge Color: ["Blue","Gold","Red"]</option>
              <option value="6">Boot Color: ["2 Tone Brown","Turquoise and Brown"]</option>
            </select>
          </div>
          <div class="col-sm-6 mt-15">
            <label for="itemNameString">Item name:</label>
            <input type="text" class="form-control" name="itemNameString" placeholder="New item name" id="itemNameString">
          </div>
          <div class="col-sm-6 mt-15">
            <label for="dimensions">Dimensions:</label>
            <input type="text" class="form-control" name="dimensions" placeholder="Dimensions" id="dimensions">
          </div>
          <div class="col-sm-6 mt-15">
            <input type="checkbox" name="addActive" id="addActive" value="1" checked>
            <label for="addActive">Active item?</label>
          </div>
          <div class="col-sm-6 mt-15">
            <input type="checkbox" name="addFeatured" id="addFeatured" value="1">
            <label for="addFeatured">Featured item?</label>
          </div>

        </div>
        <div class="row">
          <button type="submit" name="addProduct" id="add-submit" class="btn btn-primary-filled btn-rounded">Add
            Product</button>

          <!-- Server side form validation notifications. -->
          <?php
          if (!isset($_GET['addProduct'])) {
            //do nothing
          } else {
            $addProductCheck = $_GET['addProduct'];

            if ($addProductCheck == "query") {
              echo "<p class='error'>There was a database error. Please try again.</p>";
              if (isset($_GET['code'])) {
                echo "<p>Error: " . $_GET['code'] . "</p>";
              }
            } elseif ($addProductCheck == "empty") {
              echo "<p class='error'>Please fill out the form completely.</p>";
            } elseif ($addProductCheck == "error") {
              echo "<p class='error'>Form submission error. Please try again.</p>";
            } elseif ($addProductCheck == "success") {
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
        <h1 class="page-title fadeInDown animated first">Add Product Image</h1>
      </div><!-- / page-header -->
      <p class="slide-text fadeInUp animated second">Choose product from dropdown menu then click on "Add Image" button.
        File name will be displayed on product page when hovering over an image.</p>
    </div><!-- / page-header-content -->
  </div><!-- / container -->
  <div class="container add-images flex ">
    <div class="flex">
      <select name="productImageUploadSelect" id="productImageUploadSelect">
        <?php
        $get_products_sql = "SELECT * FROM products ORDER BY itemNameString;";

        /* Execute the query */
        try {
          $res1 = $pdo->prepare($get_products_sql);
          $res1->execute();
        } catch (PDOException $e) {
          /* If there is a PDO exception, throw a standard exception */
          throw new Exception('Database query error');
        }
        while ($row = $res1->fetch(PDO::FETCH_ASSOC)) { ?>
          <option value="<?php echo $row['itemName'] ?>" data-numpics="<?php echo $row['numberOfPics'] ?>"
            data-id="<?php echo $row['id'] ?>"><?php echo $row['itemNameString'] ?></option>
          <?php
        }
        ?>
      </select>
      <button id="upload_widget" class="btn btn-primary-filled btn-rounded">Add Image</button>
    </div>
    <p class="responseMessageAddImage"></p>
  </div>

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
            <th>Product Name</th>
            <th>Main Category</th>
            <th>Subcategories</th>
            <th>Prices</th>
            <th>Shipping</th>
            <th>Option IDs</th>
            <th>Dimensions</th>
            <th>Active Status</th>
            <th>Featured Status</th>
            <th>Number Of Pictures</th>
          </tr>
          <?php
          $get_products_sql = "SELECT * FROM products ORDER BY itemNameString;";

          try {
            $res2 = $pdo->prepare($get_products_sql);
            $res2->execute();
          } catch (PDOException $e) {
            throw new Exception('Database query error');
          }
          while ($row = $res2->fetch(PDO::FETCH_ASSOC)) {
            $get_image_urls_sql = "SELECT * FROM imgUrls WHERE product_id = " . $row['id'] . ";";

            /* Execute the query */
            try {
              $res3 = $pdo->prepare($get_image_urls_sql);
              $res3->execute();
            } catch (PDOException $e) {
              throw new Exception('Database query error');
            }
            $urlRow = $res3->fetch(PDO::FETCH_ASSOC);
            $picUrl = str_replace('upload/', 'upload/c_fill,h_200/', $urlRow['url']); ?>
            <tr id="<?php echo $row['id'] ?>">
              <!-- update data-img-url -->
              <td><button id="<?php echo $row['id'] ?>" class="deleteProductButton"
                  data-main-category="<?php echo $row['mainCategory'] ?>"><i class="lnr lnr-trash"></i></button></td>
              <td class="product-image-td"><img src="<?php echo $picUrl ?>" alt="<?php echo $row['itemNameString'] ?>"></td>
              <td class="itemNameString can-edit"><?php echo $row['itemNameString'] ?></td>
              <td class="mainCategory can-edit"><?php echo $row['mainCategory'] ?></td>
              <td class="subCategories can-edit"><?php echo $row['subCategories'] ?></td>
              <td class="priceArray can-edit"><?php echo $row['priceArray'] ?></td>
              <td class="shipping can-edit"><?php echo $row['shipping'] ?></td>
              <td class="optionIDs can-edit"><?php echo $row['optionIDs'] ?></td>
              <td class="dimensions can-edit"><?php echo $row['dimensions'] ?></td>
              <td class="active can-edit"><?php echo $row['active'] ?></td>
              <td class="featured can-edit"><?php echo $row['featured'] ?></td>
              <td class="numberOfPics can-edit"><?php echo $row['numberOfPics'] ?></td>
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
      <p class="slide-text fadeInUp animated second">Click the calander icon to open the date picker. Double click a name,
        location, or booth to edit the content. Press enter or click outside of a field to submit the filed data. Click a
        trashcan to delete the whole show. Click the Add Show button to add a new row.</p>
    </div><!-- / page-header-content -->
  </div><!-- / container -->

  <div class="container">
    <div id="show-table-container">
      <table class="editable">
        <tbody id="show-table-body">
          <tr>
            <th></th>
            <th class="show-start-date">Start Date</th>
            <th class="show-end-date">End Date</th>
            <th class="show-name">Name</th>
            <th class="show-location">Location</th>
            <th class="show-booth">Booth</th>
          </tr>

          <?php
          $get_shows_sql = "SELECT * FROM shows ORDER BY startDate;";

          /* Execute the query */
          try {
            $res4 = $pdo->prepare($get_shows_sql);
            $res4->execute();
          } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
          }
          while ($row = $res4->fetch(PDO::FETCH_ASSOC)) {
            $startDate = date_create($row['startDate']);
            $startDateString = date_format($startDate, "Y-m-d");
            $endDate = date_create($row['endDate']);
            $endDateString = date_format($endDate, "Y-m-d");
            ?>

            <tr id="<?php echo $row['startDate'] ?>">
              <td><button class="deleteShowButton"><i class="lnr lnr-trash"></i></button></td>
              <!-- <td class="scheduleStartDateString can-edit"><time>< ?php echo $row['startDateString']?></time></td> -->
              <td class="scheduleStartDate scheduleDate"><input type="date" value="<?php echo $startDateString ?>" /></td>
              <!-- <td class="scheduleEndDateString can-edit"><time>< ?php echo $row['endDateString']?></time></td> -->
              <td class="scheduleEndDate scheduleDate"><input type="date" value="<?php echo $endDateString ?>" /></td>
              <td class="scheduleName can-edit"><?php echo $row['name'] ?></td>
              <td class="scheduleLocation can-edit"><?php echo $row['location'] ?></td>
              <td class="scheduleBooth can-edit"><?php echo $row['booth'] ?></td>
            </tr>

            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <p id="responseMessageShow"></p>

    <button name="addShow" id="addShowButton" class="btn btn-primary-filled btn-rounded btn-edit-show">Add Show</button>


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

  <!-- cart -->
  <script src="js/cart.js"></script>
  <!-- / cart -->

  <!-- cloudinary -->
  <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
  <!-- /cloudinary -->

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
} else {
  header("Location: ./admin.php");
}
?>