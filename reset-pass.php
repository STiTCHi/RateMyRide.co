<?php
session_start();
if ( $_SESSION['usernamexxx'] != "" ) {
    header( "location:index.php" );
} //$_SESSION['usernamexxx'] != ""
$pageTitle = "Reset Password";

//MySQL Database Connect
include 'dbconnection.php';
include 'incl/encryption.php';
include 'incl/functions.php';

$username_ = sanitiseForSQL($_GET['u']);
$resetUserAuth = sanitiseForSQL($_GET['auth']);

// run the query for the Cars table // to get all the info..
// To get the images to display = )
$uploadedCars = mysql_query( "SELECT * FROM `Cars` ORDER BY RAND() LIMIT 100" );

if ( $_GET['check'] == "1" ) {
    // username and password sent from form 
    $username_ = $_POST['usernamexx'];
    $password_ = $_POST['passxx'];
    $repassword_ = $_POST['pass2xx'];
    
    // To protect MySQL injection
    $username_ = sanitiseForSQL( $username_ );
    $password_ = sanitiseForSQL( $password_ );
    $repassword_ = sanitiseForSQL( $repassword_ );

    // Run SQL Query // Check if the user is in the database.
    $result = mysql_query( "SELECT * FROM Users WHERE Username='$username_'" );
    
    // Mysql_num_row get the number of returned rows.
    $count = mysql_num_rows( $result );
    
    $reset_flag = false;

    // If result matched $username_
    //table row must be 1 row
    //echo 'count: '. $count ."\n\n";
    if ( $count > 0 ) {
        $reset_flag = true;
         //echo 'flag: '. $reset_flag ."\n\n";
        // have to use the same ip that the reset request was sent from.
        $ip = get_client_ip();
        //$resetCodeAuth = generateRandomString(16).'|'.date( "Y-m-d H:i:s" ).'|'.$ip;
        $authCode_IP = '';
        $authCode_DateTime = '';
        while ( $row3 = mysql_fetch_array( $result ) ) {

            // Get the email
            $userEmailForReset = $row3['Email'];
            $resetCodeAuth = $row3['ResetPassword'];
            //echo 'authString: '. $resetCodeAuth ."\n\n";
            $authCodeParts = explode("|", $resetCodeAuth);

            $authCode_Code = sanitiseForSQL($authCodeParts[0]);
            $authCode_DateTime = $authCodeParts[1];
            $authCode_IP = $authCodeParts[2];

        }

    } //$count == 1

    $flag2_auth = false;
    
    if($reset_flag){
        //echo "in flag      \n\n";
        //echo "ip: ".$ip." = authIP: " . $authCode_IP . "      \n\n";
        if($password_ == $repassword_){ // passwords match.
            if($resetUserAuth == $authCode_Code){ // Auth code matches
                if($ip == $authCode_IP){
                    //if($ip == $authCode_DateTime){ // not done yet will check to see if the date in the database is older than 2 hours compared to the current time.
                        mysql_query( "UPDATE `Users` SET `Password`='" . encrypt($password_, ENCRYP_KEY) . "', `ResetPassword`='' WHERE Username='" . $username_ . "'" );
                        sendEmail($userEmailForReset,'Password Reset Confirmation for RateMyRide.co',"Password Reset Confirmation for RateMyRide.co");
                        $messageReset = "Password Reset Success!";
                    //}else{$messageReset.="Reset link has expired.\n<br />\n";}
                }else{$messageReset.="IP address is not the same as the one the reset request was made from.\n<br />\n";}
            }else{$messageReset.="Incorrect authentication code - expired or has been used.\n<br />\n";}
        }else{$messageReset.="Your passwords did not match.\n<br />\n";}
    }else{$messageReset.="Username not registered.\n<br />\n";}
    //and or Reset link has expired and or .
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
					<form name="form1" method="post" action="reset-pass.php?check=1&auth=<?=$resetUserAuth?>" data-ajax="false">
                      <p><?php echo $messageReset; ?></p>
                      <div data-role="fieldcontain" >
                        <label for="usernamexx">Username</label>
                        <input type="text" name="usernamexx" id="usernamexx" value="<?= $username_ ?>" data-mini="true" required/>
                      </div>
                      <div data-role="fieldcontain" >
                        <label for="passxx">Password</label>
                        <input type="password" name="passxx" id="passxx" value="" data-mini="true" required/>
                      </div>
                      <div data-role="fieldcontain" >
                        <label for="pass2xx">Re-Password</label>
                        <input type="password" name="pass2xx" id="pass2xx" value="" data-mini="true" required/>
                      </div>
                     
                      <div style="float:right;">
                        <button data-inline="true" type="submit" name="Submit" data-mini="true" data-ajax="false">Reset Password</button>
                      </div>
                    </form>
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