<?php
	include_once("../components/php/ui.php");
	
	doHeader("How To", false);
?>

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Preamble</div>

				<p>
					This page describes how to install, configure, run, and use <span class="bold">univero.</span>
					Although the tool does not require any special skills to deal with, basic knowledge of e-publishing and access to the desired hosting account are needed.
					To use this manual, just keep in mind that each of the following sections answers one simple question: 
				</p>
			</td>
		</tr>
	</table>
	
	<div class="howto">HOW TO...</div>
	
	<br />

	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Install?</div>

				<ol>
					<li>
						Before proceeding, make sure that <span class="error">PHP 5.x.x</span> version with <span class="error">PHP Data Objects (PDO)</span> inteface can be used; or nothing will work.
						If you are not certain, do not panic; most hosting configurations DO have both by default.
					</li>
				
					<li>
						Get the latest release from the <a href="<?php echo $DOWNLOAD; ?>">download</a> page.
					</li>
					
					<li>
						Unzip the content of the downloaded archive.
					</li>
					
					<li>
						If you wish to configure files on the server, proceed to the next step; if you want to configure files on your computer and then upload them to the server, skip to <span class="italic">Configure?</span> section and later come back to the end of this section.
					</li>
					
					<li>
						Save the unzipped files to an HTTP-enabled (accessible through a browser) folder on your server.
						I recommend&mdash;not insist&mdash;that you name the folder <span class="italic">univero</span> and place it inside your Web site root folder.
						If, for example, your Web site is <span class="italic">http://www.somewebsitename.com</span> and the Web pages are stored in <span class="italic">/somewebsitename/public_html</span> folder; then <span class="italic">univero</span> folder would feel great right there.
						That is, you full path to <span class="italic">univero</span> is now <span class="italic">/somewebsitename/public_html/univero.</span>
					</li>
				</ol>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Configure?</div>

				<ol>
					<li>
						Apart from potential <span class="italic">read/write/execute</span> issues, configuring <span class="bold">univero</span> is really simple.
						After you have copied the files (or before that) to the server, go to the <span class="italic">components/php</span> folder, and open&mdash;not run&mdash;the content of <span class="italic">settings.php.</span>
						Detailed comments are provided there to help you correctly initialize each of the configuration variables.  
					</li>
					
					<li>
						I recommend that you make sure that all of your folders have the same permissions set: "rwxr-x--x" (751); and "rw-r-----" (640) for all the files (often by default).
					</li>
					
					<li>
						For security reasons you might want to set the following permissions on your database file&mdash;after it has been created&mdash;in the <span class="italic">components/db</span> directory: "rwx------" (700).
					</li>
				</ol>
			</td>
		</tr>
	</table>

	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Run?</div>

				<ol>
					<li>
						Open your browser and go to the Web address of the folder that you copied all files to on the server. 
					</li>
					
					<li>
						You will be transferred to the login screen where you will need to enter the login and password you specified in the <span class="italic">settings.php</span> file in the <span class="italic">components/php</span> folder.
					</li>
					
					<li>
						If JavaScript is enabled in your browser, you should be able to run <span class="bold">univero.</span> 
					</li>
				</ol>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table class="collapsed websiteTable">
		<tr>
			<td class="top">
				<div class="subtitle">Use?</div>

				<ol>
					<li>
						To be answered... 
					</li>
					
					<li>
						To be answered... 
					</li>
					
					<li>
						To be answered... 
					</li>
				</ol>
			</td>
		</tr>
	</table>
	
<?php
	doFooter();
?>