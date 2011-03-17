<?php
	include_once("../components/php/ui.php");
	include_once("../components/php/db.php");
	
	doHeader("Demo", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">First Things First</div>
				
				<p>
					I would like to provide a way for potential users to play with the system right on this page; yet due to security and concurrency issues, I will only let you see the end result.
					Nevertheless, feel free to <a href="<?php echo $DOWNLOAD; ?>">download</a> the tool and try the editor in action yourself.
				</p>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Formatted Reference List</div>
				
				<p>
					If you want to see an example of how a formatted list of references might look line on your Web site, then use this toggler 
					<span id="formattedListToggler" class="demo_toggler" onclick="expandField(this, 'result');">[+]</span>.
				</p>
			</td>
		</tr>
	</table>
	
	<script type="text/javascript" language="javascript">		
		function getEntriesByTag(tag) {
			if (tag == "") {
				location.href = location.href;
			}
			
			document.getElementById("tag").value = tag;
			document.getElementById("form").submit();
		}

		function expandField(toggle, id) {
			var d = document.getElementById(id);
			
			if (d.style.display == 'none') {
				toggle.innerHTML = '[&ndash;]';
				d.style.display = 'block';
			} else {
				toggle.innerHTML = '[+]';
				d.style.display = 'none';
			}
		}
	</script>
	
	<form id="form" method="post" action="">
		<input name="tag" id="tag" type="hidden" value="" />
	</form>

	<div id="result" style="display: none;">
	
<?php 
	$all_entries;

	$current_tag = "";
	
	if (isset($_POST["tag"])) {
		$current_tag = $_POST["tag"];
		$all_entries = getTaggedEntries(array($current_tag));
?>
	<script type="text/javascript" language="javascript">
		var toggle = document.getElementById("formattedListToggler");
		var d = document.getElementById("result");
			
		if (d.style.display == 'none') {
			toggle.innerHTML = '[&ndash;]';
			d.style.display = 'block';
		}
	</script>
<?php 
	} else {
		$all_entries = getAllEntries();	
	}

	echo "Tags: <br />";
	
	$all_tags = getTags();	
	
	$l = sizeof($all_tags);
	
	echo "<select onchange='getEntriesByTag(this.options[this.selectedIndex].innerHTML);' style='width: 200px;'>\n";
	
	echo "<option selected='selected'></option>\n";
	
	for ($i = 0; $i < $l; $i++) {
		echo "<option".($current_tag == $all_tags[$i] ? " selected='selected'" : "").">".$all_tags[$i]."</option>\n";
	}
	
	echo "</select>\n";
	
	echo "<br /><br />";
?>

	
	<table class="collapsed websiteTable" style="background-color: #eeeeff; font-family: Arial; font-size: 80%;">
		<tr>
			<td class="top">
<?php
	$type = "";
	$year = "";
	
	$index = 1;
	
	$l = sizeof($all_entries);
	$noEntryOfType = false;
	
	for ($i = 0; $i < $l; $i++) {
		if ($all_entries[$i]["type"] != $type) {
			$type = $all_entries[$i]["type"];
			
			$typeID = str_replace(" ", "_", $type);
			
			if ($i != 0) {
				if (!$noEntryOfType) {
?>
				</div>
<?php
				} else {
					$noEntryOfType = false;
				}
			}
			
			if (sizeof($all_entries[$i]["data"]) == 0) {
				$noEntryOfType = true;
				continue;
			}
?>
					<div class="demo_subtitle<?php echo ($i == 0 ? "" : " demo_topDoublePadding"); ?>">
<?php 
			echo $type."\n";
?>
						&nbsp;<span class="demo_toggler" onclick="expandField(this, '<?php echo str_replace(" ", "_", $typeID); ?>');">[&ndash;]</span>
					</div>
					<div id="<?php echo str_replace(" ", "_", $typeID); ?>">
<?php
		}
		
		$year = "";
		
		$s = sizeof($all_entries[$i]["data"]);
		
		for ($j = 0; $j < $s; $j++) {	
			if ($all_entries[$i]["data"][$j]["year"] != $year) {
				$year = $all_entries[$i]["data"][$j]["year"];
				
				if ($j != 0) {
?>
					</div>
<?php
				}
?>
					<div class="demo_subsubtitle<?php echo (($j == 0) ? "" : " demo_topPadding"); ?>">
<?php 
				echo $year;
?>
						&nbsp;<span class="demo_toggler" onclick="expandField(this, '<?php echo str_replace(" ", "_", $typeID).$year; ?>');">[&ndash;]</span>
					</div>
					<div id="<?php echo str_replace(" ", "_", $typeID).$year; ?>">
<?php
			}
?>
					<table class="demo_fullWidth">
						<tr>
							<td class="demo_entryIndex">
<?php 
			echo "[".$index."]&nbsp;\n";
?>
							</td>
							
							<td class="demo_fullWidth">
								<div class="demo_bottomPadding">
<?php 		
			echo $all_entries[$i]["data"][$j]["entry"]."\n";
			
?>
								</div>
							</td>
						</tr>
					</table>
<?php			
			$index++;
			
			if ($j == $s - 1) {
?>
				</div>
<?php
			}
		}
		
		if ($i == $l - 1) {
?>
			</div>
<?php
		}
	}
?>
				</td>
			</tr>
		</table>

	</div>

	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Illustrated Overview</div>
				
				<p>
					In what follows I provide a brief overview of the main sections of <span class="bold">univero</span>.
					This material is not intended as a manual, but rather a simple demonstration.
					Answers to use-related questions are provided in the <a href="<?php echo $HOW_TO; ?>">How To</a> section. 
				</p>
			</td>
		</tr>
		
		<tr>
			<td class="top">
				<div class="subsubtitle">Index</div>
				
				<p>
					This page provides basic configuration information, including the number of entries in the database and number of various uploads.
					This section is the surest way to verify that <span class="bold">univero</span> is installed correctly.
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-index.png" alt="index" />
				
				<br />
				<br />
			</td>
		</tr>
		
		<tr>
			<td class="top">
				<div class="subsubtitle">Editor (a)</div>
				
				<p>
					This page is probably the most important one, as it is what enables users to create, modify, and delete references.
					Initially, all types of references are listed as titled bars with a toggle on the right.
					The toggle expands/collapses entries of a certain kind. 
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-editor-1.png" alt="editor" />
				
				<br />
				<br />
			</td>
		</tr>
		
		<tr>
			<td class="top">
				<div class="subsubtitle">Editor (b)</div>
				
				<p>
					Once a particular reference type is expanded, all references are displayed numbered, and in chronological order, with a set of controls on the right.
					One can already notice how the formatted references appear, and how they wrap across multiple lines.
					The controls, from left to right, allow to move a reference up or down in the group within the same year, delete a reference, insert a new reference, or open a reference for editing. 
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-editor-2.png" alt="editor" />
				
				<br />
				<br />
			</td>
		</tr>

		<tr>
			<td class="top">
				<div class="subsubtitle">Editor (c)</div>
				
				<p>
					When a reference is opened for editing, a number of various fields&mdash;depending on its type&mdash;are shown.
					Possible fields include <span class="italic">Author</span>, <span class="italic">Editor</span>, <span class="italic">Title</span>, <span class="italic">Journal</span>, <span class="italic">Magazine</span>, <span class="italic">Book</span>, <span class="italic">Conference</span>, <span class="italic">Institution</span>, <span class="italic">Venue</span>, <span class="italic">Year</span>, <span class="italic">Volume</span>, <span class="italic">Issue</span>, <span class="italic">Start Page</span>, <span class="italic">End Page</span>, <span class="italic">Start Date</span>, <span class="italic">End Date</span>, <span class="italic">Place</span>, <span class="italic">Date</span>, <span class="italic">Size</span>, <span class="italic">Comment</span>, <span class="italic">File</span>, <span class="italic">URL</span>, and <span class="italic">Tags</span>.
					Each field has a different validation scheme, and is formatted in a specific way to be included in the final reference block.
					On top, <span class="italic">Author</span> and <span class="italic">Editor</span> fields support controls that, similarly to entries themselves, allow order change, addition, and removal.
					<span class="italic">File</span> enables the user to specify a preuploaded resource that needs to be associated with a particular reference.
					<span class="italic">Tags</span> field holds a list of keywords that could be used for easier search and filtering.
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-editor-3.png" alt="editor" />
				
				<br />
				<br />
			</td>
		</tr>
		
		<tr>
			<td class="top">
				<div class="subsubtitle">Editor (d)</div>
				
				<p>
					If one of the fields does not pass validation, it will be highlighted with a red-dotted border, and an error message will be displayed.
					All changes to the fields are applied immediately.
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-editor-4.png" alt="editor" />
				
				<br />
				<br />
			</td>
		</tr>

		<tr>
			<td class="top">
				<div class="subsubtitle">Editor (e)</div>
				
				<p>
					Although removal of authors and editors does not require confirmation, the user is promted one when a reference entry is being removed. 
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-editor-5.png" alt="editor" />
				
				<br />
				<br />
			</td>
		</tr>
		
		<tr>
			<td class="top">
				<div class="subsubtitle">Upload</div>
				
				<p>
					To have a link pointing to a printed publication or a multimedia file, the respective resource need to be uploaded via the <span class="italic">Upload</span> page.
				</p>
				
				<img src="<?php echo $PICS; ?>/demo-upload.png" alt="upload" />
				
				<br />
				<br />
			</td>
		</tr>
	</table>

<?php
	doFooter();
?>