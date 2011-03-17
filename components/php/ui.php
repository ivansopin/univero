<?php
	include_once("version.php");
	include_once("settings.php");
	include_once("links.php");
	include_once("menu.php");
	include_once("functions.php");

	function doHeader($title, $withJavaScript) {
		global $menu;
		
		global $ROOT;
	
		global $APP_VERSION;

		global $PAPERS_DIR;
		global $MULTIMEDIA_DIR;
		
		global $NEW_TITLE;
		
		global $NEW_JOURNAL;
		global $NEW_MAGAZINE;
		global $NEW_PROCEEDING;
		global $NEW_PRESENTATION;
		global $NEW_REPORT;
		global $NEW_CHAPTER;
		
		global $NEW_AUTHOR;
		
		global $JOURNAL_TYPE;
		global $MAGAZINE_TYPE;
		global $PROCEEDING_TYPE;
		global $MULTIMEDIA_TYPE;
		global $PRESENTATION_TYPE;
		global $REPORT_TYPE;
		global $CHAPTER_TYPE;
		
		global $JS;
		global $CSS;
		global $PICS;
		global $PHP_DIR;
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>univero: <?php echo $title; ?></title>

		<meta http-equiv="Expires" content="Thu, Jan 1 1970 00:00:00 GMT" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo $CSS; ?>/index.css" />
<?php
		if ($title == "Home" || $title == "Progress" || $title == "Demo" || $title == "How To" || $title == "Download") {
?>
		<link rel="stylesheet" type="text/css" href="<?php echo $CSS; ?>/site.css" />
<?php
		} 
?>

		<meta name="keywords" content="univero, research, reference, organizer, automatic, compiler, generator, article, sopin" />
		<meta name="description" content="UNIVersal Electronic Reference Organizer (univero)" />
		<meta name="author" content="Ivan Sopin" />
		<meta name="robots" content="all" />

<?php 
		if ($withJavaScript) {
?>
		<script type="text/javascript">
			var ROOT = "<?php echo getRelativePath($ROOT, dirname($_SERVER["PHP_SELF"]), false); ?>";
			var PHP = "<?php echo getRelativePath($PHP_DIR, dirname($_SERVER["PHP_SELF"]), false); ?>";
		
			var MAIN_AUTHOR = "<?php echo $NEW_AUTHOR; ?>";
			var PAPERS_DIR = "<?php echo $PAPERS_DIR; ?>";
			var MULTIMEDIA_DIR = "<?php echo $MULTIMEDIA_DIR; ?>";
			
			var NEW_TITLE = "<?php echo $NEW_TITLE; ?>";
			var NEW_JOURNAL = "<?php echo $NEW_JOURNAL; ?>";
			var NEW_MAGAZINE = "<?php echo $NEW_MAGAZINE; ?>";
			var NEW_PROCEEDING = "<?php echo $NEW_PROCEEDING; ?>";
			var NEW_PRESENTATION = "<?php echo $NEW_PRESENTATION; ?>";
			var NEW_REPORT = "<?php echo $NEW_REPORT; ?>";
			var NEW_CHAPTER = "<?php echo $NEW_CHAPTER; ?>";
			
			var JOURNAL_TYPE = "<?php echo $JOURNAL_TYPE; ?>";
			var MAGAZINE_TYPE = "<?php echo $MAGAZINE_TYPE; ?>";
			var PROCEEDING_TYPE = "<?php echo $PROCEEDING_TYPE; ?>";
			var MULTIMEDIA_TYPE = "<?php echo $MULTIMEDIA_TYPE; ?>";
			var PRESENTATION_TYPE = "<?php echo $PRESENTATION_TYPE; ?>";
			var REPORT_TYPE = "<?php echo $REPORT_TYPE; ?>";
			var CHAPTER_TYPE = "<?php echo $CHAPTER_TYPE; ?>";
		</script>
<?php 
			$allJS = getRelativePath($JS."/univero.js", dirname($_SERVER["PHP_SELF"]), false);

			if (!file_exists($allJS)) {
?>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/base.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/ajax.js"></script>

		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/commons.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/balloon.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/parser.js"></script>
		
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/patent.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/journal.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/magazine.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/chapter.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/proceeding.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/report.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/presentation.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/multimedia.js"></script>
<?php
			} else {
?>
				<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/univero.js"></script>
<?php 
			}
		} 
?>
	</head>
	
	<body>
		<h1>univero <?php echo $APP_VERSION; ?></h1>
	
		<table class="collapsed">
			<tr>
				<td>
					<table class="collapsed">
						<tr>
						
<?php
	$i = 0;
	$l = sizeof($menu) - 1;
	
	foreach($menu as $key => $value) {
		echo "<td>\n";
		
		if ($key == $title) {
			echo $key;
		} else {
			echo '<a class="menuLink" href="'.$value.'/">'.$key.'</a>';
		}
		
		if ($i != $l) {
			 echo "&nbsp;|&nbsp;";
		}
		
		echo "\n</td>\n";
		
		$i++;
	}
?>

						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<br />
<?php
	}

	function doFooter() {
?>
		<br />
	
		&copy;2009&ndash;2010 <a href="http://ivansopin.org">Ivan Sopin</a>. All rights reserved.

	</body>
</html>
<?php
	} 
?>