<?php

// include ImageManipulator class
require_once('ImageManipulator.php');
require_once('database_functions.php');

// PHP 5.3 adds depth as third parameter to json_decode
function jsonp_decode($jsonp, $assoc = false) {
	if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
	   $jsonp = substr($jsonp, strpos($jsonp, '('));
	}
	return json_decode(trim($jsonp,'();'), $assoc);
}

$Database_Func = new RateMyRideDatabase_Functions;

//MakeID
$MakeID = $_POST["MakeID"];
$UserID = $_POST["UserID"];

@mkdir('uploads/'.$UserID.'/');

$jsonp_string = file_get_contents("http://www.carqueryapi.com/api/0.3/?callback=?&cmd=getModel&model=".$MakeID);

//jsonp string to array
$car_specs = jsonp_decode($jsonp_string, true);

foreach ($_FILES as $file) {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($file['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = time();
		
        $manipulator = new ImageManipulator($file['tmp_name']);
        //$width  = $manipulator->getWidth();
        //$height = $manipulator->getHeight();
        //$centreX = round($width / 2);
        //$centreY = round($height / 2);
        // our dimensions will be 200x130
        //$x1 = $centreX - 100; // 200 / 2
        //$y1 = $centreY - 65; // 130 / 2
 
        //$x2 = $centreX + 100; // 200 / 2
        //$y2 = $centreY + 65; // 130 / 2
		
		$newImage = $manipulator->resample(200);
        // center cropping to 200x130
        //$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
        $manipulator->save('uploads/'.$UserID.'/200w_'. $car_specs[0]['model_id'] . "_" . $newNamePrefix . $fileExtension);
		
		
		$manipulator = new ImageManipulator($file['tmp_name']);		
		$newImage = $manipulator->resample(500);
        // saving file to uploads folder
        $manipulator->save('uploads/'.$UserID.'/500w_'. $car_specs[0]['model_id'] . "_" . $newNamePrefix . $fileExtension);
		
		$imagePath = 'uploads/'.$UserID.'/[width]_'. $car_specs[0]['model_id'] . "_" . $newNamePrefix . $fileExtension;
		$count = (count($car_specs[0])-1);
		
		unset($car_specs[$count]);
		
		echo $Database_Func->saveCarData($imagePath, $UserID, $car_specs[0]);
		
		echo 'Done ...';
    } else {
        echo 'You must upload an image...';
    }
}

?>