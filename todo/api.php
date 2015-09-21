<?php
include 'ActionHandler.php';
include 'FileScanner.php';

$method = $_SERVER['REQUEST_METHOD'];
//$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

$actionHandler = new ActionHandler();



switch ($method) {
    case 'GET':
        $scanner = new FileScanner();
        $response = $scanner->getFiles();
        // Output the directory listing as JSON
        header('Content-type: application/json; charset=UTF-8');
        
        echo json_encode(array(
            "name" => "files",
            "type" => "folder",
            "path" => Config::$workDir,
            "items" => $response
        ));
        break;
    case 'POST':
        $actionHandler->handleRequest($_POST['action']);
        break;
    default:
        throw new Exception("error");
}
