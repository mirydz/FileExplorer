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
}