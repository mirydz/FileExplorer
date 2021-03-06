<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

$requestedFileName = $_POST['file'];
$submittedPassword = $_POST['password'];

$validator = new PasswordValidator();

if( $validator->isValidPassword($submittedPassword, 'download') ) {
    $requestedFileNameSanitized = pathinfo($requestedFileName, PATHINFO_BASENAME);
    $requestedFileFullpath = Config::$workDir . '/' . $requestedFileNameSanitized;
    
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false); // required for certain browsers 
    header('Content-Disposition: attachment; filename="'. basename($requestedFileFullpath) . '";');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($requestedFileFullpath));
    
    readfile($requestedFileFullpath);
    exit;
} else {
    Config::returnHtmlWithMsg("Wrong Password!");
}
