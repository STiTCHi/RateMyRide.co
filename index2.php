<?php
session_start();
if ( $_SESSION['usernamexxx'] != "" ) {
    header( "location:index.php" );
} //$_SESSION['usernamexxx'] != ""
$pageTitle = "Login";

//MySQL Database Connect
include 'dbconnection.php';
include 'incl/encryption.php';
include 'incl/functions.php';

// run the query for the Cars table // to get all the info..
$uploadedCars = mysql_query( "SELECT * FROM `Cars` LIMIT 100" );

if ( $_GET['check'] == "1" ) {
    
    // username and password sent from form 
    $username_ = $_POST['usernamexx'];
    $password_ = $_POST['passxx'];
    
    // To protect MySQL injection
    $username_ = sanitiseForSQL( $username_ );
    $password_ = sanitiseForSQL( $password_ );
    
    // Run SQL Query // Check if the user is in the database.
    $result = mysql_query( "SELECT * FROM Users WHERE Username='$username_'" );
    
    // Mysql_num_row get the number of returned rows.
    $count = mysql_num_rows( $result );
    
    // If result matched $username_ and $password_
    //table row must be 1 row
    if ( $count == 1 ) {
        while ( $row3 = mysql_fetch_array( $result ) ) {
            // Get the encrypted pass..
            $password_en = $row3['Password'];
            // Decrypt the encrypted pass..
            if ( $password_en != "" ) {
                $password_de = decrypt( $password_en, ENCRYP_KEY );
                
            } //$password_en != ""
            $flag = false;
            if ( $password_ == $password_de ) {
                $flag = true;
            } //$password_ == $password_de
        } //$row3 = mysql_fetch_array( $result )
    } //$count == 1
    
    // True if login is correct.
    if ( $flag ) {
        
        // Get the IP of the user.
        $ip = get_client_ip();
        
        // Update Last IP for User's last login.
        mysql_query( "UPDATE `Users` SET `IP`='" . $ip . "', `LastSeen`='" . date( "Y-m-d H:i:s" ) . "' WHERE Username='" . $username_ . "'" );
        
        // Register $username_ with the session.
        $_SESSION['usernamexxx'] = $username_;
        // Then redirect to a "logged in session".
        header( "location:/" );
    } //$flag
    else {
        $messageLogin = "Incorrect Username and or Password";
    }
    
} //$_GET['check'] == "1"
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
					<form name="form1" method="post" action="login.php?check=1" data-ajax="false">
					  <div data-role="fieldcontain" >
					    <label for="usernamexx">Username</label>
					    <input type="text" name="usernamexx" id="usernamexx" value="<?= $_POST['usernamexx'] ?>" data-mini="true" required/>
					  </div>
					  <div data-role="fieldcontain" >
					    <label for="passxx">Password</label>
					    <input type="password" name="passxx" id="passxx" value="" data-mini="true" required/>
					  </div>
					  
					  <div style="float: left; margin-top: 27px; text-shadow: 0px 0px 0px; font-weight: 100; font-size: 13px;">
					  <a href="forgotten-pass.php" data-ajax="false">Forgotten Password</a>
					  </div>
					  <div style="float:right;">
					      <button data-inline="true" type="button" name="Register" data-mini="true" data-ajax="false" onClick="register()">Register</button>
					    <button data-inline="true" type="submit" name="Submit" data-mini="true" data-ajax="false">Login</button>
					  </div>
					</form>
				</div>
			</div>
        <div style="border-top: 1px solid #ee8d4f; width:auto; height:auto;">
        <div style="float:left; border-top: 1px solid #ee8d4f; height: 200px; width:350px;" id="photo_container"></div>
        </div>
        </div>
      


            

</div>
</body>
</html>