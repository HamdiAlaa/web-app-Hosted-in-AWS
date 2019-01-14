<?php

//data base
$db = new PDO('mysql:host=imagedb.cubw42gmxakj.eu-west-1.rds.amazonaws.com;dbname=images', 'root', 'your password');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//include the S3 class
if (!class_exists('S3'))require_once('S3.php');
else
echo "error upload S3 module";

//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'Your aws acces key');
if (!defined('awsSecretKey')) define('awsSecretKey', 'your aws secret key');

//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
$uploadedFile = '';
if(!empty($_FILES["file"]["type"])){
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    //$sourcePath = $_FILES['file']['tmp_name'];
    //$targetPath = "uploads/".$fileName;
    $s3->putBucket("com-rosettahub-default-alaadinne.hamdi", S3::ACL_PUBLIC_READ);
    // if(move_uploaded_file($sourcePath,$targetPath)){
    //     $uploadedFile = $fileName;
    // }

    if ($s3->putObjectFile($fileTempName, "com-rosettahub-default-alaadinne.hamdi", $fileName, S3::ACL_PUBLIC_READ)) {
        $insert = $db->query("INSERT INTO images (filename) VALUES ('".$fileName."')");
        echo "Ok";
    }else {
        echo "NotOk";
    }
}
else{
    echo "unable";
}
?>
