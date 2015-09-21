<?php 
function __autoload($class_name) {
    include $class_name . '.php';
}

class FileScanner
{
	private $dir;
	private $allowedFileTypes;

	public function __construct()
	{
		$this->dir = Config::$workDir;
		$this->allowedFileTypes = Config::$allowedFileTypes;
		//echo $this->dir;
	}
	
	public function getFiles($argDir)
	{
		$dir = $argDir ?: $this->dir; // conditional assignment
		$files = array();
		if(file_exists($dir))
		{
			foreach(scandir($dir) as $file) 
			{
				if(!$file || $file[0] == '.') 
				{
					continue; // Ignore hidden files
				}

				$isAllowed = $this->isAllowedFile($file);
				if(! $isAllowed)
					continue;

					$files[] = array(
						"name" => $file,
						"type" => "file",
						"path" => $dir . '/' . $file,
						"time" => filemtime($dir . '/' . $file),
						"size" => filesize($dir . '/' . $file), // Gets the size of this file
						"ext"  => pathinfo($file, PATHINFO_EXTENSION)
					);
			}
		
		}
		return $files;
	}
	
			
	private function isAllowedFile($fileName) 
	{
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		return in_array($ext, $this->allowedFileTypes);
	}
	
	

}