<div data-role="header">
    <div style="width: 300px; height: 7px; margin-top: -6px; margin-left: 4px; margin-bottom: -5px;">
    
      <a href="logout.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-inline" title="Log out" data-ajax="false">Log out</a> <a href="#adminpanel" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-inline" title="Settings" data-ajax="false">Settings</a> <a href="user.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-user ui-btn-icon-notext ui-btn-inline ui-btn-active" title="<?=$userInfo['Username']?>" data-ajax="false">User</a>
<a href="upload.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-camera ui-btn-icon-notext ui-btn-inline" title="Upload a car" data-ajax="false">Upload</a>	  </div>
    <div id="branding" role="banner" style="float: right;
height: 25px;
margin-right: 6px;
margin-top: 3px;"> <a href="/" data-ajax="false"><img height="32" src="images/rmr-logo.png" alt="RMR Logo"></a>
    
    </div>
    
    <h1><?php echo $messageLogin; ?></h1>
    
    <!-- navbar -->
    <div data-role="navbar">
      <ul>
        <li><a href="wall.php?q=popular" data-transition="flow" data-ajax="false"<?php if($wallType =="popular"){ echo 'class="ui-btn-active"'; }?>>Popular</a></li>
        <li><a href="wall.php?q=newest" data-transition="flow" data-ajax="false"<?php if($wallType =="newest"){ echo 'class="ui-btn-active"'; }?>>Newest</a></li>
        <li><a href="wall.php?q=random" data-transition="flow" data-ajax="false"<?php if($wallType =="random"){ echo 'class="ui-btn-active"'; }?>>Random</a></li>
      </ul>
    </div>
	  <?=$inform_message?>
    <!-- /navbar -->
  </div>
  