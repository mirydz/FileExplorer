<?php 
	
class Config 
{
	public static $workDir = "/home/ubuntu/stuff";
	public static $password = "password";
	public static $allowedFileTypes = array('txt', 'zip', 'rar', '7z');
	public static $maxAllowedFileSize = 10240; // 10 kB
	
	public static $downloadPassword = "downpass";
	public static $uploadPassword = "uppass";
	public static $deletePassword = "delpass";
	
	public static function returnHtmlWithMsg($msg) {
		echo '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>' . $msg . '</title>
          </head>
          <body>
            <script>
                window.history.back();
            </script>' 
            . $msg . ' Redirecting back...
          </body>
        </html>';
	}
}