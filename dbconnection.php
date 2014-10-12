<?php
// Set the time zone!
date_default_timezone_set('Australia/Melbourne');

// Connects to Our Database
mysql_connect("localhost", "user", "passss") or die(mysql_error()); 
mysql_select_db("superdry_db") or die(mysql_error());
?>