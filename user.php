<?php
session_start();
if($_SESSION['usernamexxx']==""){
header("location:login.php");
}

$pageTitle = "Users";

//MySQL Database Connect
include 'dbconnection.php';
include 'incl/encryption.php';

if($_REQUEST['search']!=""){$xSearch=$_REQUEST['search'];}else{$xSearch="-1";}

	if($_GET['update']=="1"){
		if($_POST['email'] !=""){

	mysql_query("UPDATE Users SET `Username`='".mysql_real_escape_string($_POST['username'])."', `Password`='".mysql_real_escape_string(encrypt($_POST['pass'], ENCRYP_KEY))."',`FirstName`='".mysql_real_escape_string($_POST['fname'])."',`AccountType`='".mysql_real_escape_string($_POST['permissions'])."',`Theme`='".mysql_real_escape_string($_POST['theme'])."' WHERE UID='".$xSearch."' OR Email='".$xSearch."'") or die(mysql_error());
		}
}


// Collects data from "Users" table 
$data = mysql_query('SELECT * FROM Users WHERE Username="'.$_SESSION['usernamexxx'].'"') or die(mysql_error());

// puts the "Users" info into the $clientInfo array 
$userInfox = mysql_fetch_array( $data );

// Collects data from "Users" table 
$data = mysql_query('SELECT * FROM Users WHERE Username="'.$_SESSION['usernamexxx'].'"') or die(mysql_error());

// puts the "Users" info into the $clientInfo array 
$userInfo = mysql_fetch_array( $data );

//Header
include('incl/header_scripts.php');

if($userInfo['Theme'] !=""){
	$themeSet = $userInfo['Theme'];
}

?>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<style>
	label.ui-input-text {
		line-height: 2.2;
	}
	.ui-block-a{
		padding-right:20px;	
	}
	.controlgroup-textinput{
    	padding-top:.22em;
    	padding-bottom:.22em;
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
.ui-menu-item{
	padding-top: 2px;
	padding-bottom: 2px;
}
.ui-btn.my-tooltip-btn,
.ui-btn.my-tooltip-btn:hover,
.ui-btn.my-tooltip-btn:active {
	height: 20px;
}
.ui-autocomplete {
z-index: 999999;
}
</style>
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
  
  <div data-role="content">
            
            <div class="ui-grid-solo">
                <div class="ui-block-a">
                    <div data-role="fieldcontain" >
                    <form action="user.php" method="get" data-inline="true" data-ajax="false">
                      <div data-role="controlgroup" data-type="horizontal" style="width: 475px;">
                      <input type="text" name="search" id="search" data-wrapper-class="controlgroup-textinput ui-btn" value="<?=$userInfox['Website']?>" placeholder="Email or User ID" autocomplete="off" class="ui-autocomplete-input"/>
                      <button type="submit" name="submit" data-ajax="false">Search</button>                      <a href="#popupInfo2" data-rel="popup" data-transition="flip" class="my-tooltip-btn ui-btn ui-btn-inline ui-icon-info ui-btn-icon-notext" title="Learn more"></a>
                    <div data-role="popup" id="popupInfo2" class="ui-content" style="max-width:350px;">
                      <p><b>Find a user quickly!</b></p>
                      <p>To help accomplish this you can search for both their email or the user id.</p>
                    </div>                    
                      </div>

                    </form>

                    </div>

                </div>
                               
            </div>
			<form action="user.php?update=1&search=<?=$userInfox['UID']?>" method="post" data-inline="true" data-ajax="false">
                <div data-role="collapsible" data-collapsed="false">
                <h4>User Infomation<?php if($userInfox['UID'] != ""){echo " - <i>(uid: ".$userInfox['UID'].")</i>";}?> <u><?=$userInfox['AccountType']?></u></h4>
                    <div class="ui-grid-a ui-responsive" style="font-size: 12px;">
                            <div class="ui-block-a">
                                
                              <div data-role="fieldcontain">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" value="<?=$userInfox['FirstName']?>"  required/>
                              </div>
							  <div data-role="fieldcontain">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" value="<?=$userInfox['Username']?>"  required/>
                              </div>
                              <div data-role="fieldcontain">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?=$userInfox['Email']?>"  required/>
                              </div>
                              <div data-role="fieldcontain">
                              	<label for="pass">Password</label>
                                <input type="text" name="pass" id="pass" value="<?=decrypt($userInfox['Password'], ENCRYP_KEY)?>"  />
                              </div>
								<fieldset data-role="controlgroup" data-mini="true">
                                    <legend>Theme</legend>
                                    <input type="radio" name="theme" id="radio-choice-v-6a" value="a"<?php if($userInfox['Theme'] =="a"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6a">Dark (orange)</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6b" value="b"<?php if($userInfox['Theme'] =="b"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6b">Light (orange)</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6c" value="c"<?php if($userInfox['Theme'] =="c"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6c">Black/White</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6d" value="d"<?php if($userInfox['Theme'] =="d"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6d">Blue/White</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6e" value="e"<?php if($userInfox['Theme'] =="e"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6e">Pink</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6f" value="f"<?php if($userInfox['Theme'] =="f"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6f">Green/Blue/White</label>
                                    <input type="radio" name="theme" id="radio-choice-v-6g" value="g"<?php if($userInfox['Theme'] =="g"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-v-6g">Other</label>
                                </fieldset>
                  
                            </div>
                            
                            <div class="ui-block-b">
                              <div data-role="fieldcontain">
                                <label for="lastip">Last IP</label>
                                <input type="text" name="lastip" id="lastip" disabled="disabled" value="<?=$userInfox['LastIP']?>"  />
                              </div>
                              <div data-role="fieldcontain">
                                <label for="lastlogin">Last login</label>
                                <input type="text" name="lastlogin" id="lastlogin" disabled="disabled" value="<?=$userInfox['LastLogin']?>"  />
                              </div>
                              <div data-role="fieldcontain">
                                <label for="date">Join Date</label>
                                <input type="text" name="date" id="date" data-role="date" disabled="disabled" value="<?=$userInfox['JoinDate']?>" placeholder="yyyy-mm-dd" required/>
                              </div>
                              
                                <fieldset data-role="controlgroup" data-mini="true">
                                    <legend>User Role</legend>
                                    <input type="radio" name="permissions" id="radio-choice-ur-6a" value="Admin" <?php if($userInfox['AccountType'] =="Admin"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-ur-6a">Admin</label>
                                    <input type="radio" name="permissions" id="radio-choice-ur-6b" value="Staff"<?php if($userInfox['AccountType'] =="Staff"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-ur-6b">Staff</label>
                                    <input type="radio" name="permissions" id="radio-choice-ur-6c" value="Client"<?php if($userInfox['AccountType'] =="Client"){?>checked="checked"<?php } ?>>
                                    <label for="radio-choice-ur-6c">Client</label>

                                </fieldset> 
                            </div>
                                
                            
                            <div align="right" style="float:left;"><button data-inline="true" type="submit" name="submit" data-mini="true" data-ajax="false">Save Changes</button></div> 
                     </div>
                </div>
            </form>            
            <br />
            
             <br />  <br />  <br />  <br />  <br />  <br />
        </div>
    
<div data-role="footer"> Copyright - RateMyRide.co </div>
    </div>
</body>
</html>