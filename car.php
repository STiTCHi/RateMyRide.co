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
if( $wallType == "" ){ $wallType = "popular"; }

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
</head>
<body class="container">
<div data-role="page" data-theme="<?=$themeSet?>">    
    <!-- panel  -->
    <div data-role="panel" id="adminpanel" data-display="push" data-position="left">  
        <a href="#" data-rel="close">Close panel</a>
	  <hr />
	  <br / >
    </div>
    <!-- /panel -->
  <div>
  <?php
  include('incl/navigation.php');
  ?>
  </div>
  
  <div data-role="content">
  
  <div id="container">

    <div id="main" role="main">

	<?=$carInfo['make_display']?>
	

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

</body>
</html>