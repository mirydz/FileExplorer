<?php
   
include 'FileScanner.php';
include 'PasswordValidator.php';

class ActionHandler {
    public function __construct() {
        $requestedFileName = $_POST['file'];
        $submittedPassword = $_POST['password'];
        $requestedActionType = $_POST['action'];
        
        $requestedFileNameSanitized = pathinfo($requestedFileName, PATHINFO_BASENAME);
        $requestedFileFullpath = Config::$workDir . '/' . $requestedFileNameSanitized;
        
        $validator = new PasswordValidator();

    }
    
    
    public function handleRequest($requestedActionType) {
        switch($requestedActionType)
        {
            case "download":
                handleDownload($requestedFileFullpath);
                break;
            case "delete":
                handleDelete($requestedFileFullpath);
                break;
        }
    }
    
    private function handleDownload($requestedFileFullpath) {
        if( $this->$validator->isValidPassword($this->$submittedPassword, 'download')) {
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false); // required for certain browsers 
            //header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'
                . basename($this->$requestedFileFullpath) . '";');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($this->$requestedFileFullpath));
            
            readfile($this->$requestedFileFullpath);
            exit;
        } else {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
    }
    
    private function handleDelete() {
        if( $this->$validator->isValidPassword(
                $this->$submittedPassword, $this->$requestedActionType) ) {
            unlink($this->$requestedFileFullpath);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
    }

    
}




