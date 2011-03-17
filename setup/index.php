<?php
	session_start();
	
	include_once("../components/php/links.php");
	  
	if (!isset($_SESSION["logged_as_".$APP_LOGIN])) {
		header("Location: ".$LOGIN."/");
		return;
	}
	
	include_once("../components/php/ui.php");
	include_once("../components/php/db.php");
	include_once("../components/php/settings.php");
	include_once("../components/php/listFiles.php");
	
	doHeader("Setup", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Access Settings</div>	

				<br />
				
				<table class="collapsed inputsTable">
					<tr>
						<td class="right">
							Login: 
						</td>
						
						<td class="fullWidth">
 							<input type="text" value="" name="login" />
						</td>
					</tr>
					
					<tr>
						<td class="right">
							Password: 
						</td>
						
						<td class="fullWidth">
 							<input type="password" value="" name="password" />
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="submit" class="fullWidth" value="Submit" />	
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<br />
	


<?php
	doFooter();
?>