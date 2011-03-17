<?php
	session_start();
	
	include_once("../components/php/links.php");
	include_once("../components/php/ui.php");
	
	doHeader("Login", false);

	if (isset($_SESSION["error"])) {
		echo "<p class=\"error\">".$_SESSION["error"]."</p>";
		unset($_SESSION["error"]);
	}

	if (isset($_SESSION["logged_as_".$APP_LOGIN])) {
		echo "<p>You are already logged in as ".$APP_LOGIN."</p>";
	} else {
		echo "<p>Login for full access to univero.</p>";
		
?>
					<form method="post" action="<?php echo $LOGIN; ?>/process.php">
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
					</form>
<?php
	}
	
	doFooter();
?>