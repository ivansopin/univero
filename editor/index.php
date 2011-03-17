<?php
	session_start();
	
	include_once("../components/php/links.php");
	  
	if (!isset($_SESSION["logged_as_".$APP_LOGIN])) {
		header("Location: ".$LOGIN."/");
		return;
	}
	
	include_once("../components/php/ui.php");
	
	doHeader("Editor", true);
?>

		<table class="titleTable">
			<tr>
				<td class="titleCell">
					JOURNALS
				</td>
				<td>
					<span id="<?php echo $JOURNAL_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $JOURNAL_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $JOURNAL_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					MAGAZINES
				</td>
				<td>
					<span id="<?php echo $MAGAZINE_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $MAGAZINE_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $MAGAZINE_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					BOOK CHAPTERS
				</td>
				<td>
					<span id="<?php echo $CHAPTER_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $CHAPTER_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $CHAPTER_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					PROCEEDINGS
				</td>
				<td>
					<span id="<?php echo $PROCEEDING_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $PROCEEDING_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $PROCEEDING_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					TECHNICAL REPORTS
				</td>
				<td>
					<span id="<?php echo $REPORT_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $REPORT_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $REPORT_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					PRESENTATIONS
				</td>
				<td>
					<span id="<?php echo $PRESENTATION_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $PRESENTATION_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $PRESENTATION_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		
		<table class="titleTable">
			<tr>
				<td class="titleCell">
					MULTIMEDIA
				</td>
				<td>
					<span id="<?php echo $MULTIMEDIA_TYPE; ?>sToggler" class="toggle" onclick="toggleDataPart('<?php echo $MULTIMEDIA_TYPE; ?>');">[&Omicron;]</span> 
				</td>
			</tr>
		</table>
		
		<table id="<?php echo $MULTIMEDIA_TYPE; ?>sTable" style="display: none;">
			<tr>
				<td></td>
			</tr>
		</table>
		

		<div id="balloon" class="balloon"></div>
		
		<script type="text/javascript" language="javascript" src="<?php echo $JS; ?>/process.js"></script>
<?php
	doFooter();
?>