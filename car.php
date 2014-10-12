<?php
session_start();
if($_SESSION['usernamexxx']==""){
	// Not logged in redirect to the login page.
	header("location:login.php");
}
//MySQL Database Connect
include 'dbconnection.php';
include 'incl/functions.php';
require_once('database_functions.php');

// Gets data from "Users" table of our database 
$data = mysql_query('SELECT * FROM Users WHERE Username="'.$_SESSION['usernamexxx'].'"') or die(mysql_error());

// Adds all the "Users" info to the array '$userInfo'.
// So it can be accessed later throughout this page.
$userInfo = mysql_fetch_array( $data );

$wallType = $_GET['q'];
$carID = $_GET['cid'];
$comment = $_POST['comment'];
// get the rating value from the user
$userRating = $_GET['ur'];

// Set the rating for this car by the current user.
if( $userRating != ""){

    // Update/insert into the database `rating` table.
    $Database_Func = new RateMyRideDatabase_Functions;
    // echo to test responce 
    
    $ans = $Database_Func->insert_rating($userInfo['UID'], $carID, $userRating, $comment);
    
    if($ans == "Success"){
        $inform_message = "<center><p>You have successfuly rated this car <b>".$userRating."</b> out of 5</p></center>";
    }
    else{
        $inform_message = "<center><p>$ans</p></center>";
    }

}

$sql = "SELECT * FROM `Rating` WHERE CarID =  '$CarID_' and NOT (Comment = '' OR Comment = NULL)";

$result_comments = mysql_query($sql);

// Sets default page view to popular, if none is set.
if( $wallType == "" ){ $wallType = "popular"; }

// run the query for the Cars table // to get all the info for a specific record in our database.
$carData = mysql_query("SELECT * FROM `Cars` WHERE CarID='". $carID. "'");

// Adds all the car info into the array '$carInfo'.
// So it can be accessed later throughout this page.
$carInfo = mysql_fetch_array( $carData );
		
// Set page title // upper case first letter ucwords()
$pageTitle = ucwords( $carInfo['make_display'] . ' ' . $carInfo['model_name'] . ': ' . $carInfo['model_year'] ) . " - RMR";

// All the style/script files + js...
include('incl/header_scripts.php'); 
?>

<!-- CSS Reset -->
<!-- <link rel="stylesheet" href="dgl-plugin/css/reset.css"> -->
<!-- Global CSS for the page and tiles -->
<link rel="stylesheet" href="dgl-plugin/css/main.css">
<!-- Specific CSS for the tiles -->
<link rel="stylesheet" href="dgl-plugin/example-filter/css/style.css">
<style>
.inner-center {
width: auto;
margin: auto;
max-width: 492px;
}


.box{
background: #f5f5f5; 
background: -moz-linear-gradient(top,  #f5f5f5 0%, #efefef 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f5f5), color-stop(100%,#efefef)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f5f5f5 0%,#efefef 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f5f5f5 0%,#efefef 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f5f5f5 0%,#efefef 100%); /* IE10+ */
background: linear-gradient(top,  #f5f5f5 0%,#efefef 100%); /* W3C */
-pie-background: linear-gradient(top,  #f5f5f5 0%,#efefef 100%); 
border-radius: 7px;
border:1px solid #d8d8d8;
}

.polaroid {
  position: relative;
  width: 480px;
}
 
.polaroid img {
  border: 10px solid #fff;
  border-bottom: 45px solid #fff;
  -webkit-box-shadow: 3px 3px 3px #777;
     -moz-box-shadow: 3px 3px 3px #777;
          box-shadow: 3px 3px 3px #777;
}
 
.polaroid p {
  position: absolute;
  text-align: center;
  width: 100%;
  bottom: 0px;
  font: 400 18px/1 'Kaushan Script', cursive;
  color: #888;
}

.comment{
    border: 1px solid #fff;
    border-bottom: 2px solid #fff;
    padding-left: 20px;
    -webkit-box-shadow: 3px 3px 3px #777;
    -moz-box-shadow: 3px 3px 3px #777;
    box-shadow: 3px 3px 3px #777;

}

#tiles li {
width: 200px;
background-color: #ffffff;
border: 1px solid #dedede;
border-radius: 2px;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
display: none;
cursor: pointer;
padding: 2px;
}

</style>
</head>

<body class="container">

<div data-role="page" data-theme="<?=$themeSet?>">    
    
    <!-- panel  -->
    <div data-role="panel" id="adminpanel" data-display="push" data-position="left">  
      <a href="#" data-rel="close">Close panel</a>
      <hr />
      <br / >
      <ol id="filters">
        <li data-filter="all">Reset filters</li>
        <li data-filter="engine">Engine</li>
        <li data-filter="image">Images</li>
      </ol>
      <hr />

      <br / >
    </div>
    <!-- /panel -->

  <div>

  <?php
  // include navigation much quicker if changes are needed.
  include('incl/navigation.php');
  ?>

  </div>

    <?php
    $imagePath = str_replace( '[width]', '500w', $carInfo['ImagePath'] );
    $make      = $carInfo['make_display'];
    $modelName = $carInfo['model_name'];
    $modelYear = $carInfo['model_year'];
    $cid       = $carInfo['CarID'];
    ?>
    <div data-role="content"><br />


        <div class="ui-grid-a ui-responsive" style="font-size: 12px;">
            <div class="ui-block-a">
                <div class="inner-center">

                    <div class="polaroid">
                        <p><?=$make.' '.$modelName.' - '.$modelYear?></p>
                        <img src="<?=$imagePath?>" alt="<?=$make.' '.$modelName.' - '.$modelYear?>" style="width:100%">
                    </div>
                </div>
            </div>
            <div class="ui-block-b">
                <div class="inner-center">
                    <div data-role="collapsible" data-collapsed="false">
                        <h4>Comments...</h4>

                        <?php
                        while ( $row = mysql_fetch_array( $result_comments ) ) {
                            // looping through the rows.
                            $c_com = $row['Comment'];
                            $c_userId = $row['UID'];
                            $c_date = $row['Ratedate'];
                            ?>

                        <div class="comment">
                            <h4><?=$c_userId. ': '. $c_date?></h4>
                            <p><?$c_com?></p>
                        </div>
                        <div style="padding-left: 20px; padding-top: 1px; padding-right: 20px;"><hr /></div>

                            <?php
                        } //$row = mysql_fetch_array( $uploadedCars2 )
                        ?>
                        
                        

                    </div>
                    <form name="form1" method="post" action="car.php?cid=<?=$carID. '&check=5&ur='.$userRating?>" data-ajax="false">
                        <div data-role="fieldcontain" >
                        <label for="comment">Make Comment</label>
                        <input type="text" name="comment" id="comment" value="<?= $_POST['comment'] ?>" data-mini="true" required/>
                        </div>

                        <div style="float:right;">
                        <button data-inline="true" type="submit" name="Submit" data-mini="true" data-ajax="false">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

  <!-- Main Content -->
  <div data-role="content">

    <div id="container">
      <div id="main" role="main">

  	    
        <ul id="tiles">
        <!--
        These are our grid items. Notice how each one has classes assigned that
        are used for filtering. The classes match the "data-filter" properties above.
        -->
        <?php if($carInfo['model_engine_position'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p ><b>Engine Position</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div>
        <p><?=$carInfo['model_engine_position']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_engine_cc'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p data-theme="a"><b>Engine cc</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div>
        <p><?=$carInfo['model_engine_cc']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_cyl'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p data-theme="a"><b>Engine cyl</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_cyl']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_type'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Type</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_type']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_valves_per_cyl'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Valves per cyl</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_valves_per_cyl']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_power_ps'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Power ps</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_power_ps']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_power_rpm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Power RPM</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_power_rpm']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_torque_nm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Torque nm</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_torque_nm']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_torque_rpm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Torque RPM</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_torque_rpm']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_engine_bore_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Bore mm</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_bore_mm']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_engine_stroke_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Stroke mm</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_stroke_mm']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_engine_compression'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Compression</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_compression']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_engine_fuel'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Engine Fuel</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_engine_fuel']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_top_speed_kph'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Top Speed</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_top_speed_kph']?> kph, <?=$carInfo['model_top_speed_mph']?> mph</p>
        </li><?php } ?>

        <?php if($carInfo['model_0_to_100_kph'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>0 to 100</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p>kph: <?=$carInfo['model_0_to_100_kph']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_drive'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Drive</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_drive']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_transmission_type'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Transmission</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_transmission_type']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_seats'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Seats</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_seats']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_doors'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Doors</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_doors']?></p>
        </li><?php } ?>

        <?php if($carInfo['model_weight_kg'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Weight</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_weight_kg']?> kg</p>
        </li><?php } ?>

        <?php if($carInfo['model_length_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Length</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_length_mm']?> mm</p>
        </li><?php } ?>


        <?php if($carInfo['model_width_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Width</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_width_mm']?> mm</p>
        </li><?php } ?>


        <?php if($carInfo['model_height_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Height</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_height_mm']?> mm</p>
        </li><?php } ?>


        <?php if($carInfo['model_wheelbase_mm'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Wheelbase</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_wheelbase_mm']?> mm</p>
        </li><?php } ?>

        <?php if($carInfo['model_lkm_hwy'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>lkm hwy</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_lkm_hwy']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_lkm_mixed'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>lkm mixed</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_lkm_mixed']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_lkm_city'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>lkm city</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_lkm_city']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_fuel_cap_l'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>fuel cap</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_fuel_cap_l']?></p>
        </li><?php } ?>


        <?php if($carInfo['model_sold_in_us'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Sold in the US</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?php
        if($carInfo['model_sold_in_us'] == "1"){
          echo "Yes";
        }
        else {
          echo "No";
        }
        ?>
        </p>
        </li><?php } ?>

        <?php if($carInfo['model_co2'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>co2</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['model_co2']?></p>
        </li><?php } ?>

        <?php if($carInfo['make_country'] != ""){?>
        <li data-filter-class='["engine"]'>
        <p><b>Country of Origin</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><?=$carInfo['make_country']?></p>
        </li><?php } ?>
<?php
$carSalesLink = "http://www.carsales.com.au/all-cars/results.aspx?silo=stock&q=(((Service%3d%5bCarsales%5d)%26(((SiloType%3d%5bDealer+used+cars%5d)%7c(SiloType%3d%5bDemo+and+near+new+cars%5d))%7c(SiloType%3d%5bBrand+new+cars+in+stock%5d)))%26((Make%7b%3d%7d%5b".$make."%5d)%7b%26%7d(Model%7b%3d%7d%5b".$modelName."%5d)))&vertical=car&sortby=TopDeal";
?>
        <li data-filter-class='["engine"]'>
        <p><b>CarSales Search</b></p>
        <div Style="padding-left:20px; padding-right:20px; ">
            <hr />
        </div><p><a href="<?=$carSalesLink?>" target="_blank">CarSales.com.au</a></p>
        </li>


        <!-- End of grid blocks -->
        </ul>

  	
      </div>

    </div>
  </div>
  <!-- /Main Content -->
  
</div>

<br />
<br />
<br />
<br />
<br />
<br />
<br />

<!--  Footer -->
<div data-role="footer"> Copyright - RateMyRide.co </div>
<!-- /Footer -->
 <!-- include jQuery -->
  <script src="dgl-plugin/libs/jquery.min.js"></script>

  <!-- Include the imagesLoaded plug-in -->
  <script src="dgl-plugin/libs/jquery.imagesloaded.js"></script>

  <!-- Include the plug-in -->
  <script src="dgl-plugin/jquery.wookmark.js"></script>

  <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
    (function ($){
      $('#tiles').imagesLoaded(function() {
        // Prepare layout options.
        var options = {
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#main'), // Optional, used for some extra CSS styling
          offset: 2, // Optional, the distance between grid items
          itemWidth: 210, // Optional, the width of a grid item
          fillEmptySpace: true // Optional, fill the bottom of each column with widths of flexible height
        };

        // Get a reference to your grid items.
        var handler = $('#tiles li'),
            filters = $('#filters li');

        // Call the layout function.
        handler.wookmark(options);

        /**
         * When a filter is clicked, toggle it's active state and refresh.
         */
        function onClickFilter(e) {
          var $item = $(e.currentTarget),
              activeFilters = [],
              filterType = $item.data('filter');

          if (filterType === 'all') {
            filters.removeClass('active');
          } else {
            $item.toggleClass('active');

            // Collect active filter strings
            filters.filter('.active').each(function() {
              activeFilters.push($(this).data('filter'));
            });
          }

          handler.wookmarkInstance.filter(activeFilters, 'or');
        }

        // Capture filter click events.
        $('#filters').on('click.wookmark-filter', 'li', onClickFilter);
      });
    })(jQuery);
  </script>
</body>
</html>