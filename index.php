<?php
	include_once("components/php/ui.php");
	
	doHeader("Home", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<img src="<?php echo $PICS; ?>/logo.png" alt="logo" />
			</td>
			
			<td class="top leftPadding">
				<div class="subtitle">About</div>
			
				<p>
					The <span class="bold">univero</span> project is an attempt to simplify the creation, formatting, and retrieval of scholarly and other references on the Web; the name stands for <span class="italic">UNIVersal Electronic Reference Organizer.</span>
					In short, <span class="bold">univero</span> provides many researchers with an opportunity to build, modify, and maintain libraries with publication entries and corresponding resources in a properly compiled and organized format. 
					This tool can be a tremendous help to someone who needs to quickly update their r&eacute;sum&eacute; online or prepare references for any electronic document.
				</p>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Technologies</div>

				<p>
					The entire project was built from scratch using PHP, JavaScript, AJAX, CSS, and SQLite.
					The original intent was to also use XML and XLST, but due to the limitations of the latter, JavaScript workarounds were found instead.
					Besides, the first implementation featured MySQL database, yet SQLite seemed to offer more flexibility and better performance in the scope of this project. 
				</p>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Contact</div>
					<script type="text/javascript" src="<?php echo $JS."/service.js"; ?>"></script>

				<p>
					The project is a work in progress.
					Please feel free to email me at <script type="text/javascript">eSend();</script> with any comments or suggestions you might have.
					I am currently looking for someone who is interested in advancing <span class="bold">univero</span> further and making it a really universal referencing tool.   
				</p>
			</td>
		</tr>
	</table>

<?php
	doFooter();
?>