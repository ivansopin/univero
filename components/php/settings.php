<?php
	// the root for univero, relative
	// to the hosting root folder
	$ROOT = "/univero";
	
	// folders to store the papers and 
	// other referenced files, relative
	// to the hosting root folder
	$PAPERS_DIR = $ROOT."/papers";
	$MULTIMEDIA_DIR = $ROOT."/multimedia";
	
	// login and password for
	// accessing univero
	$APP_LOGIN = "administrator";
	$APP_PASSWORD = "password";
	
	// maximum size of a file
	// for upload (in bytes)
	$MAX_FILE_SIZE = 50 * 1024 * 1024;
	
	// the name of the database file
	// (do not append any extension)
	$DB_NAME = "univero";
	
	
	
	
	
	
	
	// this will be the title for
	// every newly created entry;
	// leaving it empty has not
	// been tested; besides, you 
	// can always search for this
	// value to check if you've 
	// skipped something
	$NEW_TITLE = "New Title";
	
	// these are "fillers" for various
	// types of entries upon creation
	$NEW_JOURNAL = "New Journal";
	$NEW_MAGAZINE = "New Magazine";
	$NEW_PROCEEDING = "New Proceeding";
	$NEW_PRESENTATION = "New Presentation";
	$NEW_REPORT = "New Report";
	$NEW_CHAPTER = "New Book";
	
	// these are the names for every
	// newly created author and editor;
	// leaving it empty has not
	// been tested
	$NEW_AUTHOR = "Sopin, Ivan";
	$NEW_EDITOR = "Sopin, Ivan";
	
	// these are just constants to
	// define different entry types;
	// it is not recommended to 
	// change them without a good
	// reason 
	$JOURNAL_TYPE = "journal";
	$MAGAZINE_TYPE = "magazine";
	$PROCEEDING_TYPE = "proceeding";
	$MULTIMEDIA_TYPE = "multimedia";
	$PRESENTATION_TYPE = "presentation";
	$REPORT_TYPE = "report";
	$CHAPTER_TYPE = "chapter";
?>