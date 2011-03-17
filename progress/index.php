<?php
	include_once("../components/php/ui.php");
	
	doHeader("Progress", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.4.3</div>

				<ul>
					<li>
						Authentication for multiple deployment on one hosting made independent 
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.4.2</div>

				<ul>
					<li>
						Redundant CSS classes (needed for this site) removed from the build stylesheet 
					</li>
				
					<li>
						Several issues with styles of entry control buttons fixed 
					</li>
				
					<li>
						A single entry of a certain reference type made removable
					</li>
					
					<li>
						A bug with duplicate tag strings returned by <span class="italic">getTags()</span> function fixed
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.4.1</div>

				<ul>
					<li>
						The comment limit is increased to 200 for multimedia entries 
					</li>
				
					<li>
						A bug for not updating multimedia records fixed 
					</li>
				
					<li>
						The <span class="italic">Status</span> section of the <span class="italic">Index</span> page is populated with indicators for various settings 
					</li>

					<li>
						Support for tag-based search added 
					</li>
					
					<li>
						A bug for not updating authors and editors for reports and chapters fixed 
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.4.0</div>

				<ul>
					<li>
						A class <span class="italic">ext_ref</span> ("external reference") is added to every link within a formatted reference, to have the ability to hide it in the CSS file for printing
					</li>
					
					<li>
						A session-based authorization check is now done in <span class="italic">controller.php</span> 
					</li>
					
					<li>
						Apostrophe-escaping problem (extra "\" in the database) on hosted servers is solved by performing <span class="italic">stripslashes()</span> on the entire <span class="italic">$_REQUEST</span> 
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.3.0</div>

				<ul>
					<li>
						MySQL database was replaced with SQLite3 database
					</li>
					
					<li>
						Authors and editors do get deleted from the database upon entry deletion
					</li>
					
					<li>
						<span class="italic">Index</span> page was added for the tool installation 
					</li>
					
					<li>
						<span class="italic">How To</span> page was updated on the Web site 
					</li>
					
					<li>
						The development of the tool is synchronized with the Web site, and the current build package creation is automated 
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.2.0</div>

				<ul>
					<li>
						Web site version was released
					</li>
					
					<li>
						The tool development was integrated to the Web site structure
					</li>
					
					<li>
						Support of <span class="italic">book chapter</span> element was added
					</li>
					
					<li>
						PHP-file includes were reorganized  
					</li>
					
					<li>
						All settings were extracted to a single <span class="italic">settings.php</span> file in the <span class="italic">/components/php</span> folder   
					</li>
					
					<li>
						File upload tool was added
					</li>
					
					<li>
						Logo was designed
					</li>
					
					<li>
						Everything is conformed to XHTML 1.0 Transitional standard
					</li>
				</ul>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">1.1.0</div>

				<ul>
					<li>
						First stable version was released
					</li>
					
					<li>
						<span class="italic">Journal article, magazine article, conference proceeding, technical report, presentation, </span> and <span class="italic">multimedia</span> types are supported 
					</li>
					
					<li>
						Entries can be created, moved, or deleted within/from each year group
					</li>
					
					<li>
						Automatic by-year sorting is performed upon year change
					</li>
					
					<li>
						Before submission, every entry field is validated, and neat error messages are displayed when problems are detected 
					</li>
					
					<li>
						Unlimited number of authors or authors and editors can be created for different types of entries, with the ability to reposition, edit, and delete any author and editor
					</li>
					
					<li>
						For each entry, a file can be specified from one or the other external folder
					</li>
					
					<li>
						For any entry-specific file, a proper extension-based <span class="italic">anchor</span> link is appended to the reference 
					</li>
					
					<li>
						For each entry, a URL can be specified to be appended to the reference
					</li>
					
					<li>
						References are compiled to correctly handle non-breaking elements, initials, punctuations, and so on.
					</li>
					
					<li>
						All references are auto-formatted and saved with the entry fields to the database
					</li>
				</ul>
			</td>
		</tr>
	</table>

<?php
	doFooter();
?>