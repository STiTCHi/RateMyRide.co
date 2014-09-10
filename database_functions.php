<?php
session_start();
if($_SESSION['usernamexxx']==""){
	// Not logged in redirect to the login page.
	header("location:login.php");
}

//MySQL Database Connect
include 'dbconnection.php';

class RateMyRideDatabase_Functions
{

	// Save/add car upload data. 
    public function saveCarData($image_path,$UserID,$args)
    {
	
		// To protect MySQL injection
		$image_path = stripslashes($image_path);
		$image_path = mysql_real_escape_string($image_path);

		
		$sql = sprintf(
		'INSERT INTO `Cars` (UID,ImagePath,%s) VALUES ("'.$UserID.'","'.$image_path.'","%s")',
		implode(',',array_keys($args)),
		implode('","',array_values($args))
		);
		$result	= mysql_query($sql);
		return $sql;
		if($result)	{ return "Success"; } else { return "Error"; }

        return "Error";
    }
	
}

?>