<?php

class PasswordValidator {
	
    public function isValidPassword($passwordString, $operationType) {
        switch($operationType) {
            case "download":
                return ($passwordString == Config::$downloadPassword);
                break;
            case "upload":
                return ($passwordString == Config::$uploadPassword);
                break;
            case "delete":
                return ($passwordString == Config::$deletePassword);
                break;    
            default: 
                $error = "invalid operation type";
                throw new Exception($error);
        }
    }
	
}