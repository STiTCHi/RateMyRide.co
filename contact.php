<?php
$pageTitle = "Contact Us";

//MySQL Database Connect
include 'dbconnection.php';
include 'incl/functions.php';

// run the query for the Cars table // to get all the info..
// To get the images to display = )
$uploadedCars = mysql_query( "SELECT * FROM `Cars` ORDER BY RAND() LIMIT 100" );

// All the style/script files.
include( 'incl/header_scripts.php' );
?>
<!-- Google Hosted jQuery -->
<script src="http://www.google.com/jsapi"></script>
<script>google.load("jquery", "1");</script>
<!-- jQuery Image Scale Carousel CSS & JS -->
<link rel="stylesheet" href="isc/lib.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="isc/jQuery.isc/jQuery.isc.css" type="text/css" media="screen" charset="utf-8">
<script src="isc/jQuery.isc/jquery-image-scale-carousel.js" type="text/javascript" charset="utf-8"></script>
<script>
var carousel_images = [
<?php
if ( $uploadedCars ) {
    $imagePath = "";
    while ( $row = mysql_fetch_array( $uploadedCars ) ) {
        // looping through the rows displaying the cars in the grids $row
        $imagePath = str_replace( '[width]', '500w', $row['ImagePath'] );
        echo '"'.$imagePath.'",';
    } //$row = mysql_fetch_array( $uploadedCars )
    echo '"'.$imagePath.'" ];';
} //$uploadedCars
else {
    echo mysql_error();
}

?>

// Example without autoplay
//$(window).load(function() {
//   $("#photo_container").isc({
//       imgArray: carousel_images
//   }); 
//});

// Example with autoplay
$(window).load(function() {
    $("#photo_container").isc({
        imgArray: carousel_images,
        autoplay: true,
        autoplayTimer: 2000, // 5 seconds.
    });
});
</script>
<style>
label.ui-input-text {
    line-height: 2.2;
}
.ui-block-a {
    padding-right: 20px;
}
.controlgroup-textinput {
    padding-top: .22em;
    padding-bottom: .22em;
}
.ui-controlgroup-horizontal .ui-controlgroup-controls {
    margin-top: -15px;
    margin-bottom: -10px;
}
.ui-autocomplete {
    background: #0C0C0C;
    color: #fff;
    width: 300px;
    border-radius: 10px;
    padding-top: 20px;
    padding-bottom: 10px;
}
.ui-state-focus {
    cursor: pointer;
    border-bottom: #f9ac54 solid 1px;
}
.ui-menu-item {
    padding-top: 2px;
    padding-bottom: 2px;
}
.ui-btn.my-tooltip-btn, .ui-btn.my-tooltip-btn:hover, .ui-btn.my-tooltip-btn:active {
    height: 20px;
}
.ui-autocomplete {
    z-index: 999999;
}
.ui-mobile label, div.ui-controlgroup-label {
font-weight: normal;
font-size: 12.5px;
}
.inner-center {
width: auto;
margin: auto;
max-width: 455px;
}
</style>
<script>
function register() {
    window.location.href = "http://ratemyride.co/register.php";
}
</script>
</head>
<body class="container">
<div data-role="page" data-theme="<?= $themeSet ?>">    
    <!-- panel  -->
    <div data-role="panel" id="adminpanel" data-display="push" data-position="right">  
        <a href="#" data-rel="close">Close panel</a>
    </div>
    <!-- /panel -->
  
  <div data-role="header">
    <div style="width: 300px; height: 7px; margin-top: -6px; margin-left: 4px; margin-bottom: -5px;">
    
      <a href="" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-inline" title="Log out" data-ajax="false">Log out</a> <a href="" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-inline" title="Settings" data-ajax="false">Settings</a> <a href="#" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-user ui-btn-icon-notext ui-btn-inline ui-btn-active" title="<?= $userInfo['Username'] ?>" data-ajax="false">User</a> </div>
    <div id="branding" role="banner" style="float: right; height: 30px; margin-right: 6px; margin-top: 7px;"> <a href="/" data-ajax="false"><img height="32" src="images/rmr-logo.png" alt="RMR Logo"></a>
    
    </div>
    
    <h1><?php
echo $messageLogin;
?></h1>
    
		    <!-- navbar -->
		    <div data-role="navbar">
		      <ul>
		        <li><a href="login.php" data-ajax="false" class="ui-btn-active">Login</a></li>
		        <li><a href="register.php" data-ajax="false">Register</a></li>
		      </ul>
		    </div>
		    <!-- /navbar --> 
  
			<div data-role="content"> <br />
				<div class="inner-center">
					<br />
<center><b><i>We can be contacted by the following method:<br />
Email<br />
&<br />
contact@ratemyride.co</i></b></center>
<br />
<br />
<p>
<i><u><b>Email</b></u></i><br />
Thomas Smith - <s3385817@student.rmit.edu.au><br />
Ian Tan Jun Wei - <s3502942@student.rmit.edu.au><br />
Jack Yong Kit Liew - <s3349318@student.rmit.edu.au><br />
Wong Weng Hock - <s3453435@student.rmit.edu.au><br />
Ravindra Sakpal - <3512667@student.rmit.edu.au><br />
</p>
<br />

				</div>
			</div>
        <br />
        <div style="border-top: 1px solid #ee8d4f; width:auto; 
-webkit-box-shadow: inset 2px 4px 86px 28px rgba(0,0,0,0.75);
-moz-box-shadow: inset 2px 4px 86px 28px rgba(0,0,0,0.75);
box-shadow: inset 2px 4px 86px 28px rgba(0,0,0,0.75);
height:auto; opacity: 0.4; filter: alpha(opacity=40);">
        <div style="float:left; border-top: 1px solid #ee8d4f; height: 250px; width:385px;" id="photo_container"></div>
        </div>

		</div>
      
	</div>
<!--<div data-role="footer" class="ui-bar" style="height:30px; position:absolute; bottom:0; left:0; border-top: 1px solid #ee8d4f;">Copyright - RateMyRide.co </div>-->
</div>
</body>
</html>