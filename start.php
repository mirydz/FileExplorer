<?php
include 'FileScanner.php';

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