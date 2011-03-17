<?php
	$JOURNAL_CREATE = "
		CREATE TABLE journal (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			journal TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			volume INTEGER NOT NULL, 
			issue INTEGER NOT NULL, 
			start_page INTEGER NOT NULL, 
			end_page INTEGER NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$MAGAZINE_CREATE = "
		CREATE TABLE magazine (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			magazine TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			volume INTEGER NOT NULL, 
			issue INTEGER NOT NULL, 
			start_page INTEGER NOT NULL, 
			end_page INTEGER NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$CHAPTER_CREATE = "
		CREATE TABLE chapter (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			book TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$MULTIMEDIA_CREATE = "
		CREATE TABLE multimedia (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			size INTEGER NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$PRESENTATION_CREATE = "
		CREATE TABLE presentation (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			venue TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			date TEXT NOT NULL, 
			place TEXT NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$PROCEEDING_CREATE = "
		CREATE TABLE proceeding (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			conference TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			start_date TEXT NOT NULL, 
			end_date TEXT NOT NULL, 
			place TEXT NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$REPORT_CREATE = "
		CREATE TABLE report (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			title TEXT NOT NULL, 
			institution TEXT NOT NULL, 
			year INTEGER NOT NULL, 
			place TEXT NOT NULL, 
			comment TEXT NOT NULL, 
			file TEXT NOT NULL, 
			sequence INTEGER NOT NULL, 
			entry TEXT NOT NULL, 
			url TEXT NOT NULL, 
			tag TEXT NOT NULL
		);";
		
	$AUTHOR_CREATE = "
		CREATE TABLE author (
			entry_id INTEGER NOT NULL,
			entry_type TEXT NOT NULL, 
			name TEXT NOT NULL, 
			sequence INTEGER NOT NULL
		);";
		
	$EDITOR_CREATE = "
		CREATE TABLE editor (
			entry_id INTEGER NOT NULL,
			entry_type TEXT NOT NULL, 
			name TEXT NOT NULL, 
			sequence INTEGER NOT NULL
		);";
?>