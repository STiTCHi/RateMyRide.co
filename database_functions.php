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



		//Rating data

		public function insert_rating($UserID_, $CarID_, $UserRating_)

		{

		// To protect MySQL injection

		$UserID_ = stripslashes($UserID_);

		$UserID_ = mysql_real_escape_string($UserID_);

		

		$CarID_ = stripslashes($CarID_);

		$CarID_ = mysql_real_escape_string($CarID_);

		

		$UserRating_ = stripslashes($UserRating_);

		$UserRating_ = mysql_real_escape_string($UserRating_);



		$sql_check = "SELECT * 
			FROM  `Rating` 
			WHERE UID =  '$UserID_'
			AND CarID =  '$CarID_'";

		$check_result	= mysql_query($sql_check);

		$num_of_rows = mysql_num_rows($check_result);



			// Some check if this car has been rated by this user before

	    	if($num_of_rows > 0){



	    		// SQL Statement to update a record for a rating

	    		$sql = "UPDATE `Rating` SET `Rating`='$UserRating_', `Ratedate`='".date("Y-m-d H:i:s")."' WHERE UID =  '$UserID_'	AND CarID =  '$CarID_'";

				$result	= mysql_query($sql);

					if($result)	{ return "Success"; } else { return "Error: ". mysql_error(); }

			        return "Error";

			    	}

	    	else{

				// SQL Statement to insert a new record for a rating

	    		$sql = 'INSERT INTO `Rating` (UID,CarID,Rating,RateDate) VALUES ("'.$UserID_.'","'.$CarID_.'","'.$UserRating_.'","'.date("Y-m-d H:i:s").'")';

	    		

				$result	= mysql_query($sql);

					if($result)	{ return "Success"; } else { return "Error: ". mysql_error(); }

			        return "Error";

				} 

		

	}

}
?>