<?php
	include_once("settings.php");
	include_once("functions.php");
	include_once("version.php");

	function dirList ($directory) {
		// create an array to hold directory list
		$results = array();
		
		if (!file_exists($directory)) {
			mkdir($directory, 0755);
		}
		
		// create a handler for the directory
		$handler = opendir($directory);
	
		// keep going until all files in directory have been read
		while ($file = readdir($handler)) {
	
			// if $file isn't this directory or its parent,
			// add it to the results array
			if ($file != '.' && $file != '..')
			$results[] = $file;
		}
	
		// tidy up: close the handler
		closedir($handler);
	
		// done!
		return $results;
	}
	
	function getNumOfPapers() {
		global $PAPERS_DIR;
		
		$pathToMoveTo = getRelativePath($PAPERS_DIR, dirname($_SERVER["PHP_SELF"]), false);
		
		$files = dirList($pathToMoveTo);
		
		return sizeof($files);
	}
	
	function getNumOfMultimedia() {
		global $MULTIMEDIA_DIR;
		
		$pathToMoveTo = getRelativePath($MULTIMEDIA_DIR, dirname($_SERVER["PHP_SELF"]), false);
		
		$files = dirList($pathToMoveTo);
		
		return sizeof($files);
	}
	
	function getPaperNames() {
		global $PAPERS_DIR;
		
		$pathToMoveTo = getRelativePath($PAPERS_DIR, dirname($_SERVER["PHP_SELF"]), false);
		
		$files = dirList($pathToMoveTo);
	
		$str = "new Array(";
		
		for ($i = 0; $i < sizeof($files); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "\"".$files[$i]."\"";
		}
		
		$str .= ")";
		
		return $str;
	}
	
	function getMultimediaNames() {
		global $MULTIMEDIA_DIR;
		
		$pathToMoveTo = getRelativePath($MULTIMEDIA_DIR, dirname($_SERVER["PHP_SELF"]), false);
		
		$files = dirList($pathToMoveTo);
	
		$str = "new Array(";
		
		for ($i = 0; $i < sizeof($files); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "\"".$files[$i]."\"";
		}
		
		$str .= ")";
		
		return $str;
	}
	
	function getBuildFiles() {
		global $BUILD;
		global $APP_VERSION;
		
		$pathToMoveTo = getRelativePath($BUILD, dirname($_SERVER["PHP_SELF"]), false);
		
		$files = dirList($pathToMoveTo);
		
		for ($i = 0; $i < sizeof($files); $i++) {
			if ($files[$i] == ("univero-".$APP_VERSION.".zip")) {
				unset($files[$i]);
				
				$i--;					
			}
		}
		
		return $files;
	}
?>