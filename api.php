<?php
$method = $_SERVER['REQUEST_METHOD'];
//$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

$actionHandler = new ActionHandler();



switch ($method) {
    case 'GET':
        $actionHandler->listFiles();
        rest_get();
        break;
    case 'POST':
        $actionHandler->handleRequest($_POST['action']);
        break;
    default:
        throw new Exception("error");
}
