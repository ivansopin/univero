<?php
	session_start();
	
	include_once("../components/php/links.php");
	  
	if (!isset($_SESSION["logged_as_".$APP_LOGIN])) {
		header("Location: ".$LOGIN."/");
		return;
	}
	
	include_once("../components/php/ui.php");
	include_once("../components/php/settings.php");
	include_once("../components/php/functions.php");
	
	$UPLOAD_DIRS = array(
		"multimedia" => array(
			"dir"     =>	$MULTIMEDIA_DIR,
			"name"    =>	"Multimedia",
		),
		"papers" => array(
			"dir"     =>	$PAPERS_DIR,
			"name"    =>	"Papers",
		)
	);
	
	doHeader("Upload", false);
	
	function path_options() {
		global $UPLOAD_DIRS;
		
		$option = "";
		
		foreach ($UPLOAD_DIRS as $path => $pinfo) {
			$option .= '<option value="'.$path.'">'.$pinfo["name"].'</option>';
		}
		
		return $option;
	}
	
	function check_vals() {
		global $UPLOAD_DIRS, $err;
		
		if (!ini_get("file_uploads")) {
			$err .= "HTTP file uploading is blocked in php configuration file (php.ini). Please, contact to server administrator."; 
			return 0; 
		}
		
		$pos = strpos(ini_get("disable_functions"), "move_uploaded_file");
		
		if ($pos !== false) {
			$err .= "PHP function move_uploaded_file is blocked in php configuration file (php.ini). Please, contact to server administrator."; 
			return 0; 
		}
		
		if (!isset($_POST["path"]) || (strlen($_POST["path"]) == 0)) {
			$err .= "Please fill out path";
			return 0;
		}
		
		if (!isset($UPLOAD_DIRS[$_POST["path"]])) {
			$err .= "Incorrect path"; 
			return 0;
		}
		
		if (!isset($_FILES["userfile"])) {
			$err .= "Empty file"; 
			return 0;
		} elseif (!is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			$err .= "Empty file"; 
			return 0;
		}
		
		return 1;
	}
	
	$err = "";
	
	$status = 0;
	
	if (isset($_POST["upload"])) {
		if (check_vals()) {
			if (filesize($_FILES["userfile"]["tmp_name"]) > $MAX_FILE_SIZE) {
				$err .= "You exceeded the maximum file size limit.";
			} else {
				$pathToMoveTo = getRelativePath($UPLOAD_DIRS[$_POST["path"]]["dir"], dirname($_SERVER["PHP_SELF"]), false);
				
				if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $pathToMoveTo."/".$_FILES["userfile"]["name"])) {
					$status = 1;
				} else {
					$err .= "There are some errors.";
				}
			}
		}
	}
	
	if (!$status) {
		if (strlen($err) > 0) echo "<p class='error'>$err</p>";
	} else {
		echo "<p>".$_FILES["userfile"]["name"]." was successfully uploaded.</p>";
	}
?>

<p>
	Maximum file size: <?php echo $MAX_FILE_SIZE/1024; ?> Kb.
</p>

<form enctype="multipart/form-data" action="index.php" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $MAX_FILE_SIZE; ?>" />
	
	<table class="collapsed inputsTableWide">
		<tr>
			<td class="right">
				Folder:
			</td>
			<td style="width: 70%;">
				<select name="path">
					<?php echo path_options(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="right">
				Choose&nbsp;file:
			</td>
			<td style="width: 70%;">
				<input type="file" value="" name="userfile" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="upload" value="Upload" />
			</td>
		</tr>
	</table>
</form>

<?php
	doFooter();
?>