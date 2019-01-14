<?php
// // Include the database configuration file
// include 'conf.php';
// $statusMsg = '';

// // File upload path
// if (!class_exists('S3'))require_once('S3.php');
// if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIRC47XVEI23JXXZQ');
// if (!defined('awsSecretKey')) define('awsSecretKey', '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');
// $s3 = new S3(awsAccessKey, awsSecretKey);
// $targetDir = $path;
// $fileName = basename($_FILES["file"]["name"]);
// $targetFilePath = $targetDir . $fileName;
// $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

// if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
//     // Allow certain file formats
//     $allowTypes = array('jpg','png','jpeg','gif','pdf');
//     if(in_array($fileType, $allowTypes)){
//         // Upload file to server
//         if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
//             // Insert image file name into database
//             $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
//             if($insert){
//                 $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
//             }else{
//                 $statusMsg = "File upload failed, please try again.";
//             } 
//         }else{
//             $statusMsg = "Sorry, there was an error uploading your file.";
//         }
//     }else{
//         $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
//     }
// }else{
//     $statusMsg = 'Please select a file to upload.';
// }

//data base
$db = new PDO('mysql:host=imagedb.cubw42gmxakj.eu-west-1.rds.amazonaws.com;dbname=images', 'root', 'Mba5922949822;');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//include the S3 class
if (!class_exists('S3'))require_once('S3.php');
else
echo "error upload S3 module";

//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIRC47XVEI23JXXZQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

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