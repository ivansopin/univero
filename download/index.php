<?php
	include_once("../components/php/ui.php");
	include_once("../components/php/version.php");
	include_once("../components/php/listFiles.php");
	
	doHeader("Download", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Current Build</div>

				<p>
					The current build (<?php echo $APP_VERSION; ?>) of <span class="bold">univero</span> is available on this Web site at
				</p>
				
				<p class="indented">
					<a href="<?php echo $BUILD."/univero-".$APP_VERSION.".zip"; ?>"><?php echo $BUILD."/univero-".$APP_VERSION.".zip"; ?></a>
				</p>
				
				<p>
					I recommend that you always download the latest release for a fresh install or update.
					If for compatibility or other reason you need to obtain one of the previous builds, please refer to the following section. 
				</p>
			</td>
		</tr>
	</table>

	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Previous Builds</div>

				
<?php
	$files = getBuildFiles();
	 
	if ($files == null || sizeof($files) == 0) {
		echo "<p>None</p>";
	} else {
		foreach ($files as $value) {
			echo "<p class='indented'>\n";
			echo "<a href='".$BUILD."/".$value."'>".$value."</a>\n";
			echo "</p>\n";
		}
	}
?>
			</td>
		</tr>
	</table>
	
<?php
	doFooter();
?>