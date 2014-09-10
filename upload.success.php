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
    <div data-role="panel" id="adminpanel" data-display="push" data-position="left">  
        <a href="#" data-rel="close">Close panel</a>
    </div>
    <!-- /panel -->
  
  <?php
  include('incl/navigation.php');
  ?>
  
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

Upload success! ;P

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