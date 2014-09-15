<?php
session_start();
if($_SESSION['usernamexxx']==""){
	// Not logged in redirect to the login page.
	header("location:login.php");
}
//MySQL Database Connect
include 'dbconnection.php';
include 'incl/encryption.php';
include 'incl/functions.php';

// Gets data from "Users" table of our database 
$data = mysql_query('SELECT * FROM Users WHERE Username="'.$_SESSION['usernamexxx'].'"') or die(mysql_error());

// Adds all the "Users" info to the array '$userInfo'.
// So it can be accessed later throughout this page.
$userInfo = mysql_fetch_array( $data );

$wallType = $_GET['q'];

// Sets the page default to popular, if none is set.
if( $wallType == "" ){ $wallType = "popular"; }

$pageTitle = ucwords( $wallType ) . " - RMR";

// run the query for the Cars table // to get all the info..
$uploadedCars2 = mysql_query("SELECT DISTINCT make_display FROM `Cars`");

// run the query for the Cars table // to get all the info..
$uploadedCars = mysql_query("SELECT * FROM `Cars`");

		
// All the style/script files.
include('incl/header_scripts.php');
?>
  <!-- CSS Reset -->
  <link rel="stylesheet" href="dgl-plugin/css/reset.css">

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
	  <?php			
			if ($uploadedCars2) {
			
				while($row = mysql_fetch_array($uploadedCars2)) {
					// looping through the rows.
					$make		= $row['make_display'];
					?>
					<li data-filter="<?=$make?>"><?=$make?></li>
					<?php
				}
			}
			?>
	</ol>
	<hr />
		
    </div>
    <!-- /panel -->
  <div>
  <?php
  include('incl/navigation.php');
  ?>
  </div>
  
  <div data-role="content">
  
  <div id="container">
    <!--
      These are our filter options. The "data-filter" classes are used to identify which
      grid items to show.
      -->
	  
    <!-- Grid Filter!
	<br/>
	<ol id="filters">
      <li data-filter="all">Reset filters</li>
      <li data-filter="new">Newest</li>
      <li data-filter="popular">Popular</li>
    </ol>
    <br/>
	 -->
    <div id="main" role="main">

      <ul id="tiles">
        <!--
          These are our grid items. Notice how each one has classes assigned that
          are used for filtering. The classes match the "data-filter" properties above.
          -->
		  
		  
		<?php			
			if ($uploadedCars) {
			
				while($row = mysql_fetch_array($uploadedCars)) {
					// looping through the rows displaying the cars in the grids $row
					$imagePath 		= str_replace('[width]','200w',$row['ImagePath']);
					$make					= $row['make_display'];
					$modelName		= $row['model_name'];
					$modelYear		= $row['model_year'];
					$cid						= $row['CarID'];
					?>
					<a href="car.php?cid=<?=$cid?>"><li data-filter-class='["new", "<?=$make?>"]'>
					<img src="<?=$imagePath?>" width="200">
					<p>** ★★★★★ **</p>
					<hr />
					<p><b><?=$make. ' - ' . $modelName . ' ('.$modelYear.')'?></b></p>
					</li>	</a>				
					<?php
				}

			}
			else {
				echo mysql_error();
			}
		?>
		  
        <!-- End of grid blocks -->
      </ul>

    </div>
  </div>
  
  </div>
  
  
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<div data-role="footer"> Copyright - RateMyRide.co </div>



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