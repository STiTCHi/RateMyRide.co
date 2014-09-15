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
        delay: 350
      },
      hide: {
        effect: "slide",
        delay: 1050
      }
    });
  });
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
      padding: 20px;">
      
     
<center><h2>Upload Your Car</h2></center>
<form enctype="multipart/form-data" method="post" action="upload.php">
	<label for="car-years" title="Select the Year">Step 1)</label>
	
		<center><select width="20" name="car-years" id="car-years" data-role="none" title="Select the Year"></select></center> <br />
		<label for="car-makes" title="Select the Make">Step 2)</label>
	
		<center><select width="20" name="car-makes" id="car-makes" data-role="none" title="Select the Make"></select></center><br />
	<label for="car-model-trims" title="Select the Model">Step 3)</label>
	
		<center><select width="20" name="car-models" id="car-models" data-role="none" title="Select the Model"></select></center><br />
	<label for="car-model-trims" title="Select the Trim">Step 4)</label>
	
		<center><select width="20" name="car-model-trims" id="car-model-trims" data-role="none" title="Select the Trim"></select></center><br />
		<br />
		<div id="car-model-data"></div>
		<br />
	

	<div class="row">
	  <label for="fileToUpload" title="Select image to upload">Step 5)</label>
	  <hr />
	  <input type="file" name="filesToUpload[]" id="filesToUpload" />
	  <center>
	  <output id="filesInfo"></output>
	  </center>
	</div>
	<br />
	<div class="row">
	  <center><input id="uploadsubmit" type="submit" value="Upload" /></center>
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