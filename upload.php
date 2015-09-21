<?php
function __autoload($class_name) {
    include $class_name . '.php';
}

$submittedPassword = $_POST['password'];
$validator = new PasswordValidator();

if( $validator->isValidPassword($submittedPassword, "upload") ) {
    
    if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
            throw new RuntimeException('Invalid parameters.');
    }
    
    if( $_FILES['file']['size'] >= Config::$maxAllowedFileSize ) {
        // file too big
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
    
    $uploadDir = Config::$workDir;
    $uploadedFileNewFullPath = $uploadDir . '/' . basename($_FILES['file']['name']);

    //echo '<pre>';
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFileNewFullPath)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Something wrong\n";
    }
    
    echo 'Here is some more debugging info:';
    echo $submittedPassword;
    print_r($_POST);
    // echo '<br/>';
    // print_r($submittedPassword)
    // echo '<br/>';
    print_r($_FILES);
    print_r($uploadDir);
    echo '<br/>';
    print_r($uploadedFileNewFullPath);
    //print "</pre>";               
} else {
    echo 'validation failed';
}

 
                
            
    
    
// } catch(RuntimeException $e) {
//     echo $e->getMessage();
// }

    

// if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
//   echo "File ". $_FILES['userfile']['name'] ." uploaded successfully.\n";
//   echo "Displaying contents\n";
//   readfile($_FILES['userfile']['tmp_name']);
// } else {
//   echo "Possible file upload attack: ";
//   echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
// }

// if( isset($_FILES['file'] ) ) {
//     if( $_FILES['file']['size'] >= Config::$maxAllowedFileSize ) {
//         // file too big
//         header('HTTP/1.1 401 Unauthorized');
//         exit;
//     } else {
//         // File within limit
//         header('Status: 200');
//     }
// }

