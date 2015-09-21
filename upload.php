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
    
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if (! in_array($ext, Config::$allowedFileTypes)) {
        $msg = "File type not allowed.";
        Config::returnHtmlWithMsg("$msg");
        exit;
    }
    
    $uploadDir = Config::$workDir;
    $uploadedFileNewFullPath = $uploadDir . '/' . basename($_FILES['file']['name']);

   
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFileNewFullPath)) {
        $msg = "File succesfully uploaded!";
    } else {
        $msg = "Soething went wrong!";
        Config::returnHtmlWithMsg("$msg");
        exit;
    }
             
} else {
    $msg = "Wrong password!";
}

Config::returnHtmlWithMsg("$msg");
exit;
