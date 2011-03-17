<?php 

	function getRelativePath($pathFromRoot, $currentDir, $endWithSlash) {
		$size1 = strlen($pathFromRoot);
		$size2 = strlen($currentDir);
		
		if ($size1 == 0 || $size2 == 0) {
			return "/";
		}
		
		if (substr($pathFromRoot, 0, 1) != "/" || substr($currentDir, 0, 1) != "/") {
			return "/";
		}
		
		if (substr($pathFromRoot, $size1 - 1) == "/") {
			$pathFromRoot = substr($pathFromRoot, 0, $size1 - 1);
		}
		
		if (substr($currentDir, $size1 - 1) == "/") {
			$currentDir = substr($currentDir, 0, $size2 - 1);
		}
		
		$pathFromRootFolders = explode("/", $pathFromRoot);
		$currentDirFolders = explode("/", $currentDir);
		
		$count1 = count($pathFromRootFolders);
		$count2 = count($currentDirFolders);
		
		$count = ($count1 > $count2 ? $count1 : $count2);
		
		$commonPath = "";
		$additionalPath = "";
		
		$same = true;
		$currentLevel = 0;
		$commonLevels = 0;
		
		for ($i = 1; $i < $count; $i++) {
			if ($i < $count1) {
				if ($i < $count2) {
					if ($same && $pathFromRootFolders[$i] == $currentDirFolders[$i]) {
						$commonPath .= ("/".$pathFromRootFolders[$i]);
						$commonLevels += 1;
					} else {
						$additionalPath .= ("/".$pathFromRootFolders[$i]);
						$same = false;
					}
				} else {
					$additionalPath .= ("/".$pathFromRootFolders[$i]);
				}
			}
			
			if ($i < $count2) {
				$currentLevel += 1;
			}
		}
		
		if ($additionalPath != "") {
			$additionalPath = substr($additionalPath, 1);
		}
		
		$path = "";

		$count = $currentLevel > $commonLevels ? ($currentLevel - $commonLevels) : 0;
		
		for ($i = 0; $i < $count; $i++) {
			$path .= "../";
		}
		
		$path .= $additionalPath;
		$size = strlen($path);
		
		if ($endWithSlash != null && $endWithSlash) {
			if (substr($path, $size - 1) != "/") {
				$path .= "/";
			}
		} else {
			if (substr($path, $size - 1) == "/") {
				$path = substr($path, 0, $size - 1);
			}
		}
		
		return $path;
	}

	function updateSettingsFile($key, $oldValue, $newValue, $numeric) {
		$path = getRelativePath($SETUP, dirname($_SERVER["PHP_SELF"]), true)."settings.php";
		$oldValue = "\$".$key." = ".($numeric ? "" : "\"").$oldValue.($numeric ? "" : "\"");
		$oldValue = "\$".$key." = ".($numeric ? "" : "\"").$newValue.($numeric ? "" : "\"");
		
		$str = implode("\n", file($path));

		$str = str_replace($oldValue, $newValue, $str);

		$fp = fopen($path, "w");
				
		fwrite($fp, $str, strlen($str));
	}
	
?>