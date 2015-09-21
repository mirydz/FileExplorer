<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

$submittedPassword = $_POST['password'];
$validator = new PasswordValidator();

if( $validator->isValidPassword($submittedPassword, "upload") ) {
    
    if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
        $msg = "Invalid parameters.";
        Config::returnHtmlWithMsg("$msg");
        exit;
    }
    
    if( $_FILES['file']['size'] >= Config::$maxAllowedFileSize ) {
        // file too big
        $msg = "File is too big. Max allowd file is: " . Config::$maxAllowedFileSize;
        Config::returnHtmlWithMsg("$msg");
        exit;
    }
    
    $uploadDir = Config::$workDir;
    $uploadedFileNewFullPath = $uploadDir . '/' . basename($_FILES['file']['name']);

    //echo '<pre>';
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFileNewFullPath)) {
        $msg = "File succesfully uploaded!";
    } else {
        $msg = "Soething went wrong!";
        Config::returnHtmlWithMsg("$msg");
        exit;
    }
    
    // echo 'Here is some more debugging info:';
    // echo $submittedPassword;
    // print_r($_POST);
    // echo '<br/>';
    // print_r($submittedPassword)
    // echo '<br/>';
    // print_r($_FILES);
    // print_r($uploadDir);
    // echo '<br/>';
    // print_r($uploadedFileNewFullPath);
    //print "</pre>";               
} else {
    $msg = "Wrong password!";
}

Config::returnHtmlWithMsg("$msg");
exit;
