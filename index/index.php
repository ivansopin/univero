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
	
	doHeader("Index", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<img src="<?php echo $PICS; ?>/logo.png" alt="logo" />
			</td>
			
			<td class="top leftPadding">
				<div class="subtitle">Quick Tips</div>
			
				<script type="text/javascript" src="<?php echo $JS."/service.js"; ?>"></script>
			
				<ul>				
					<li>
						Use the <span class="italic">Status</span> section on this page for a brief summary of the system's configuration.
						Anything in red indicates incompatibilities.
					</li>
					
					<li>
						The <span class="bold">univero</span> project Web site: <a href="<?php echo $UNIVERO; ?>"><?php echo $UNIVERO; ?></a>.
					</li>
					
					<li>
						Before using <span class="bold">univero</span> for the first time, read the <a href="<?php echo $UNIVERO."/howto"; ?>">How To</a> section from the Web site.
					</li>
					
					<li>
						For feedback and support, email <script type="text/javascript">eSend();</script><noscript>I\/A|\|S0PI|\|@G|\/|AI|_.C0|\/|</noscript>.
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Status</div>
				
				<br />
				
				<div class="indented">
					<div class="subsubtitle">Database</div>

					<ul>
						<li>
							PDO SQLite Drivers:
<?php
	$pdo_drivers = PDO::getAvailableDrivers();

	$l = sizeof($pdo_drivers);

	$count = 0;
	
	for ($i = 0; $i < $l; $i++) {
		if (strpos($pdo_drivers[$i], "sqlite") !== false) { 
			if ($count != 0) {
				echo ", ";
			}
			
			echo "<span class='bold'>".$pdo_drivers[$i]."</span>";
			
			$count++;
		}
	}
	
	if ($count == 0) {
		echo "<span class='error'>None</span>";
	}
?>
						</li>
					
						<li>
							Database Name: <span class="bold"><?php echo $DB_NAME; ?></span>
						</li>
<?php
	$db_info = getDBInfo();

	if ($db_info == null) { 
?>
						<li>
							SQLite3 Access: <span class="error">not configured</span>
						</li>
<?php
	} else {
?>
						<li>
							SQLite3 Access: <span class="bold">configured</span>
						</li>
					
						<li>
							Number of Entries: <span class="bold"><?php echo $db_info["count"]; ?></span>
						</li>
<?php
	}
?>
					</ul>
				</div>
				
				<div class="indented">
					<div class="subsubtitle">JavaScript</div>

					<ul>
						<li>
							JavaScript Support:
							 
							<script type="text/javascript">
								document.write("<span class='bold'>enabled</span>");

								var r;
								
								try {
									r = new XMLHttpRequest();
								} catch (trymicrosoft) {
									try {
										r = new ActiveXObject("Msxml2.XMLHTTP");
									} catch (othermicrosoft) {
										try {
											r = new ActiveXObject("Microsoft.XMLHTTP");
										} catch (failed) {
											r = false;
										}  
									}
								}
								
								document.write("</li>");
								
								document.write("<li>");
								document.write("AJAX Support: ");
								
								if (!r) {
									document.write("<span class='error'>disabled</span>");
								} else {
									document.write("<span class='bold'>enabled</span>");
								}
							</script>
							
							<noscript><span class="error">disabled</span></noscript>
						</li>
					</ul>
				</div>
				
				<div class="indented">
					<div class="subsubtitle">Uploads</div>

					<ul>
						<li>
							Papers: 
<?php
	echo "<span class='bold'>".getNumOfPapers()."</span>";
?>
						</li>
						
						<li>
							Multimedia: 
<?php
	echo "<span class='bold'>".getNumOfMultimedia()."</span>";
?>
						</li>
					</ul>
				</div>
			</td>
		</tr>
	</table>

<?php
	doFooter();
?>