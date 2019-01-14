<?php
// Database configuration
$dbHost     = "imagedb.cubw42gmxakj.eu-west-1.rds.amazonaws.com";
$dbUsername = "root";
$dbPassword = "your password";
$dbName     = "cloud_app";
// Upload images configuration
$vpc_domaine_name ="";
$folder_name = "uploads/";
$path=$vpc_domaine_name . $folder_name;
//echo $path; 
// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
