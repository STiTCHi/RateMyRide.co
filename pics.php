<?php
session_start();
if($_SESSION['usernamexxx']==""){
	// Not logged in redirect to the login page.
	header("location:login.php");
}
//MySQL Database Connect
include 'dbconnection.php';
include 'incl/functions.php';

// Gets data from "Users" table of our database 
$data = mysql_query('SELECT * FROM Users WHERE Username="'.$_SESSION['usernamexxx'].'"') or die(mysql_error());

// Adds all the "Users" info to the array '$userInfo'.
// So it can be accessed later throughout this page.
$userInfo = mysql_fetch_array( $data );

$carID = $_GET['cid'];

$wallType = $_GET['q'];

// Sets default page view to popular, if none is set.
if( $wallType == "" ){ $wallType = "pics"; }

// Set page title // upper case first letter ucwords()
$pageTitle = ucwords( $wallType ) . " - RMR";

// run the query for the Cars table // to get all the info for a specific record in our database.
$carData = mysql_query("SELECT * FROM `Cars` WHERE CarID='". $carID. "'");

// Adds all the car info into the array '$carInfo'.
// So it can be accessed later throughout this page.
$carInfo = mysql_fetch_array( $carData );
		
// All the style/script files + js...
include('incl/header_scripts.php'); 
?>

<!-- CSS Reset -->
<!--<link rel="stylesheet" href="dgl-plugin/css/reset.css">-->
<!-- Global CSS for the page and tiles -->
<link rel="stylesheet" href="dgl-plugin/css/main.css">
<!-- Specific CSS for the tiles -->
<link rel="stylesheet" href="dgl-plugin/example-filter/css/style.css">
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
  
  <!-- Main Content -->
  <div data-role="content">
    <center><h2><?=$carInfo['make_display'] . ' ' . $carInfo['model_name'] . ' (' . $carInfo['model_year'] . ')'?> - Image Search</h2></center>
    <div id="container">
      <div id="main" role="main">
  	    
        <ul id="tiles">
        <!--
        These are our grid items. Notice how each one has classes assigned that
        are used for filtering. The classes match the "data-filter" properties above.
        -->
        <?php
            // Bing account key
        $accountKey = 'NpSpHd61lP/B/fWw5GHb9wF1nEyg6OViXw1GNW6ZLtE';
        $ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/';  
        $WebSearchURL = $ServiceRootURL . 'Image?$format=json&Query=';

        $request = $WebSearchURL . urlencode( '\'' . $carInfo['make_display'] . ' ' . $carInfo['model_name'] . ' ' . $carInfo['model_year'] . '\'');

        $process = curl_init($request);
        curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($process, CURLOPT_USERPWD,  $accountKey . ":" . $accountKey);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($process);

        //echo $response;

        $jsonobj = json_decode($response);

        echo('<ul ID="resultList">');

        foreach($jsonobj->d->results as $value)
        {                        
          ?>
          <li data-filter-class='["image"]'>
          <img src="<?=$value->Thumbnail->MediaUrl?>" width="200">
          <p></p>
          </li>
          <?php
        }
        ?>

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