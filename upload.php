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
<script type="text/javascript" src="http://www.carqueryapi.com/js/carquery.0.3.3.js"></script>
<script type="text/javascript">
$(document).ready(
function()
{
     //Create a variable for the CarQuery object.  You can call it whatever you like.
     var carquery = new CarQuery();

     //Run the carquery init function to get things started:
     carquery.init();
     
     //Optionally, you can pre-select a vehicle by passing year / make / model / trim to the init function:
     //carquery.init('2000', 'dodge', 'Viper', 11636);

     //Optional: Pass sold_in_us:true to the setFilters method to show only US models. 
     //carquery.setFilters( {sold_in_us:true} );

     //Optional: initialize the year, make, model, and trim drop downs by providing their element IDs
     carquery.initYearMakeModelTrim('car-years', 'car-makes', 'car-models', 'car-model-trims');
});
</script>
<script>
  $(function() {
    var tooltips = $( "[title]" ).tooltip({
      position: {
        my: "left top",
        at: "right+5 top-5"
      },
      show: {
        effect: "slide",
        delay: 2000
      },
      hide: {
        effect: "slide",
        delay: 250
      }
    });
  });
</script>
<style>
.inner-center {
width: auto;
margin: auto;
max-width: 455px;
font-size: 12px;
}
.selectUpload{
height: 25px;
padding: 2px;
radius: 8px 8px 8px;
margin-top: 8px;
min-width: 200px;
}
.labelUpload{
text-align: left;
width: 100% !important;
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
  

<div data-role="header">
    <div style="width: 300px; height: 7px; margin-top: -6px; margin-left: 4px; margin-bottom: -5px;">
    
      <a href="logout.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-inline" title="Log out" data-ajax="false">Log out</a> <a href="#adminpanel" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-inline" title="Settings" data-ajax="false">Settings</a> <a href="user.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-user ui-btn-icon-notext ui-btn-inline ui-btn-active" title="<?=$userInfo['Username']?>" data-ajax="false">User</a>
<a href="upload.php" style="height: 8pxpx;" class="ui-btn ui-shadow ui-corner-all ui-icon-camera ui-btn-icon-notext ui-btn-inline" title="Upload a car" data-ajax="false">Upload</a>    </div>
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
    <!-- /navbar -->


                  <form enctype="multipart/form-data" method="post" action="upload.php">
                    <div class="ui-grid-a ui-responsive" style="font-size: 12px; max-width: 600px; margin: auto;">
                      
                        <br />
                        <center><h2>Select Your Car Details</h2></center>
                        <div class="ui-block-a">
                          <center>

                            <div data-role="fieldcontain">
                              <label for="car-years" title="Select the Year" class="labelUpload">Step 1)&nbsp;&nbsp;&nbsp;&nbsp;Select the Year</label>
                              <select width="20" name="car-years" id="car-years" data-role="none" class="selectUpload"></select>
                            </div>

                          </center>
                        </div>
                              
                        <div class="ui-block-b">
                            <center>

                              <div data-role="fieldcontain">
                              <label for="car-makes" title="Select the Make" class="labelUpload">Step 2)&nbsp;&nbsp;&nbsp;&nbsp;Select the Make</label>
                              <select width="20" name="car-makes" id="car-makes" data-role="none" class="selectUpload"></select>
                            </div>

                            </center>
                        </div>

                        <div class="ui-block-a">
                            <center>

                              <div data-role="fieldcontain">
                                <label for="car-model-trims" title="Select the Model" class="labelUpload">Step 3)&nbsp;&nbsp;&nbsp;&nbsp;Select the Model</label>
                                <select width="20" name="car-models" id="car-models" data-role="none" class="selectUpload"></select>
                              </div>

                            </center>
                        </div>

                        <div class="ui-block-b">
                            <center>

                              <div data-role="fieldcontain">
                                <label for="car-model-trims" title="Select the Trim" class="labelUpload">Step 4)&nbsp;&nbsp;&nbsp;&nbsp;Select the Trim</label>
                                <select width="20" name="car-model-trims" id="car-model-trims" data-role="none" class="selectUpload"></select>
                              </div>

                            </center>
                        </div>
                     
                    </div>

                <div data-role="content"> <br />
                  <div class="inner-center">

                          <div data-role="fieldcontain">
                            

  <div class="row">
    <label for="fileToUpload" title="Select image to upload">Step 5)&nbsp;&nbsp;&nbsp;&nbsp;Upload Your Car pic here...</label>
    <center><input type="file" name="filesToUpload[]" id="filesToUpload" /></center>
    <center>
    <br />
    <output id="filesInfo"></output>
    </center>
  </div>
  <br />
  <div class="row">
    <center><input id="uploadsubmit" type="submit" value="Upload" /></center>
  </div>




                          </div>

                        
                      </div>
                            
                     </div>

                  </form>


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
<script>
$("#uploadsubmit").click(function (e) {
e.preventDefault()

var e = document.getElementById("car-model-trims");
var theID = e.options[e.selectedIndex].value;
//alert("The Make ID: " + theID);
document.getElementById('filesInfo').innerHTML = 'Uploading your car details now.<br /><img src="incl/images/loading_bar.gif" alt="Uploading Car Data">';
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(ev){

    if(xhr.readyState == 4 && xhr.status == 200) {
	document.getElementById('filesInfo').innerHTML = 'your car has been uploaded, and added to your profile.';
        //alert(xhr.responseText);
    }
	
};
xhr.open('POST', 'upload.process.php', true);

var files = document.getElementById('filesToUpload').files;
var data = new FormData();
data.append( 'MakeID', theID );
data.append( 'UserID', '<?=$userInfo['UID']?>' );

for(var i = 0; i < files.length; i++) data.append('file' + i, files[i]);
xhr.send(data);

})
function fileSelect(evt) {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var files = evt.target.files;
 
        var result = '';
        var file;
        for (var i = 0; file = files[i]; i++) {
            // if the file is not an image, continue
            if (!file.type.match('image.*')) {
                continue;
            }
 
            reader = new FileReader();
            reader.onload = (function (tFile) {
                return function (evt) {
                    var div = document.createElement('div');
                    div.innerHTML = '<img style="width: 90px;" src="' + evt.target.result + '" />';
                    document.getElementById('filesInfo').appendChild(div);
                };
            }(file));
            reader.readAsDataURL(file);
        }
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
}
 
document.getElementById('filesToUpload').addEventListener('change', fileSelect, false);
//document.getElementById("uploadsubmit").addEventListener("click", uploadSubmit);
</script>
</body>
</html>