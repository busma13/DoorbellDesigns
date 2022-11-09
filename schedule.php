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
                <!-- <p class="slide-text fadeInUp animated second">Your page's description goes here...</p> -->
            </div><!-- / page-header-content -->
        </div><!-- / container -->
    </div><!-- / page-header -->
    <hr>
</header>
<!-- / header -->

<!-- content -->

<!-- schedule -->
<section id="schedule">
    <div class="container">
        <div class="text-wrap">
            <div class="page-header text-center space-top-30">
                <h3>Show Schedule</h3>
            </div><!-- / page-header -->
            <table>
                <tbody class="show">
                    <tr class="flex-container">
                        <th class="show-date">Date</th>
                        <th class="show-name">Name</th>
                        <th class="show-location">Location</th>
                        <th class="show-booth">Booth</th>
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
while ($row = $res->fetch(PDO::FETCH_ASSOC)) { 
    if ($row['startDateString'] == $row['endDateString']) {
        $dateString = $row['startDateString'];
    } else {
        $dateString = $row['startDateString'] . ' - ' . $row['endDateString'];
    }
    
?>
                    
                    <tr class="flex-container">
                        <td><time><?php echo $dateString?></time></td>
                        <td><?php echo $row['name']?></td>
                        <td><?php echo $row['location']?></td>
                        <td><?php echo $row['booth']?></td>
                    </tr>
                
<?php
}
?>
                
                <tr class="flex-container">
                        <td></td>
                        <td>* Denotes confirmed show</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
             
        </div><!-- / text-wrap -->   
    </div><!-- / container -->
</section>
<!-- / schedule -->

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

<!-- preloader -->
<script src="js/preloader.js"></script>
<!-- / preloader -->

<!-- / javascript -->
</body>

</html>