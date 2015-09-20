<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

$requestedFileName = $_POST['file'];
$submittedPassword = $_POST['password'];
$requestedActionType = $_POST['action'];

$requestedFileNameSanitized = pathinfo($requestedFileName, PATHINFO_BASENAME);
$requestedFileFullpath = Config::$workDir . '/' . $requestedFileNameSanitized;

$validator = new PasswordValidator();

if( $validator->isValidPassword($submittedPassword, $requestedActionType) ) {
    unlink($requestedFileFullpath);
} else {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}
