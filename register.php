<?php
session_start();
if($_SESSION['usernamexxx']!=""){
header("location:index.php");
}
$pageTitle = "Register";

// MySQL Database Connect
require_once('dbconnection.php');
require_once('incl/encryption.php');
require_once('incl/functions.php');

if($_GET['check']=="1"){
	
	// Sent from the reg form 
	$fname_		= $_POST['fnamexx'];
	$lname_		= $_POST['lnamexx'];
	$username_	= $_POST['usernamexx'];
	$email_		= $_POST['emailxx']; 
	$password_	= $_POST['passxx'];
	$repassword_= $_POST['repassxx'];

	
	// No user name!
	if($username_ != ""){
		// To protect MySQL injection
		$fname_	= sanitiseForSQL($fname_);

		$lname_	= sanitiseForSQL($lname_);

		$username_	= sanitiseForSQL($username_);
		$password_	= sanitiseForSQL($password_);
		$repassword_= sanitiseForSQL($repassword_);
		$email_		= sanitiseForSQL($email_);
	
		// Run SQL Query // Check if the username is in the database.
		$result	= mysql_query("SELECT * FROM Users WHERE Username='$username_'");
		
		// Mysql_num_row get the number of returned rows.
		$count	= mysql_num_rows($result);
		
		$flag = true;
		if($password_!= $repassword_){
			$message = "Your passwords did not match!";
			$flag = false;
		}
		
		if($count > 0){ // Username in use
			$message = "Username is not available!";
			$flag = false;
		}
		if($flag){ // Good to go // can add user.// Passwords Match // Username not in use.			
			$ip = get_client_ip();
			$password_en = encrypt($password_, ENCRYP_KEY); 
			$dt = date('Y-m-d H:i:s');
			$result	= mysql_query("
			INSERT INTO `Users`(`UID`, `FirstName`, `LastName`, `Username`, `Password`, `Email`, `AccountType`, `JoinDate`, `LastSeen`, `IP`)
			VALUES
			(NULL,'$fname_','$lname_','$username_','$password_en','$email_','User','$dt','$dt','$ip')");
			?>
            <script>
			alert("<?=$username_?>\nAccount creation complete.\nYou may now login. :)");
			window.location.href = "http://ratemyride.co/login.php";

			</script>
            <?php
		}
	}else{$message ="No username entered!";}
}
// All the style/script files.
include('incl/header_scripts.php');
?>
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
</style>
<script>
function register() {
    window.location.href = "http://ratemyride.co/register.php";
}
</script>
</head>
<body class="container">
<div data-role="page" data-theme="<?=$themeSet?>">    
    <!-- panel  -->
    <div data-role="panel" id="adminpanel" data-display="push" data-position="right">  
        <a href="#" data-rel="close">Close panel</a>
    </div>
    <!-- /panel -->
  
  <div data-role="header">
    <div style="width: 300px; height: 7px; margin-top: -6px; margin-left: 4px; margin-bottom: -5px;">
    
      <a href="" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-inline" title="Log out" data-ajax="false">Log out</a> <a href="" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-inline" title="Settings" data-ajax="false">Settings</a> <a href="#" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-user ui-btn-icon-notext ui-btn-inline ui-btn-active" title="<?=$userInfo['Username']?>" data-ajax="false">User</a> </div>
    <div id="branding" role="banner" style="float: right; height: 30px; margin-right: 6px; margin-top: 7px;"> <a href="/" data-ajax="false"><img height="32px" src="images/rmr-logo.png" alt="RMR Logo"></a>
    
    </div>
    
    <h1><?php echo $message; ?></h1>
    
    <!-- navbar -->
    <div data-role="navbar">
      <ul>
        <li><a href="wall.php?q=popular" data-ajax="false">Popular</a></li>
        <li><a href="wall.php?q=newest" data-ajax="false">Newest</a></li>
        <li><a href="wall.php?q=random" data-ajax="false">Random</a></li>
      </ul>
    </div>
    <!-- /navbar --> 
  
  </div>
  <div data-role="content"> <br />
    <br />
    <br />
    <div class="ui-grid-b" style="padding: 5px;">
      <div class="ui-block-a"></div>
      <div class="ui-block-b" style="
      border-radius: 0px;
      box-shadow: 0 0 8px rgba(255, 161, 53, 1.0);
      border: solid 1px rgba(255, 161, 53, 1.0);
      padding: 20px;
      background-color: #333;">
      
        <form name="form1" id="form1" method="post" action="register.php?check=1" data-ajax="false">
          <div data-role="fieldcontain" >
            <label for="fnamexx">First Name</label>
            <input type="text" name="fnamexx" id="fnamexx" value="<?=$_POST['fnamexx']?>" data-mini="true" required/>
          </div>
          <div data-role="fieldcontain" >
            <label for="lnamexx">Last Name</label>
            <input type="text" name="lnamexx" id="lnamexx" value="<?=$_POST['lnamexx']?>" data-mini="true" required/>
          </div>
          <div data-role="fieldcontain" >
            <label for="usernamexx">Username</label>
            <input type="text" name="usernamexx" id="usernamexx" value="<?=$_POST['usernamexx']?>" data-mini="true" required/>
          </div>
          <div data-role="fieldcontain" >
            <label for="emailxx">Email</label>
            <input type="email" name="emailxx" id="emailxx" value="<?=$_POST['emailxx']?>" data-mini="true" required/>
          </div>
          <div data-role="fieldcontain" >
            <label for="passxx">Password</label>
            <input type="password" name="passxx" id="passxx" value="" data-mini="true" required/>
          </div>
          <div data-role="fieldcontain" >
            <label for="repassxx">Re-Password</label>
            <input type="password" name="repassxx" id="repassxx" value="" data-mini="true" required/>
          </div>
          
          <div align="right" style="float:right;">
            <button data-inline="true" type="submit" name="Submit" data-mini="true" data-ajax="false">Register</button>
          </div>
        </form>
      </div>
      <div class="ui-block-c"></div>
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
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>
<div data-role="footer"> Copyright - RateMyRide.co </div>
</div>
</body>
</html>