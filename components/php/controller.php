<?php 
	session_start();

	include_once("settings.php");
	include_once("links.php");
	include_once("db.php");
	include_once("php2json.php");
	include_once("listFiles.php");
	  
	if (!isset($_SESSION["logged_as_".$APP_LOGIN])) {
		header("Location: ".$LOGIN."/");
		return;
	}
	
	function getData() {
		$str = "data = [".
				convertAllJournals2JSON(getJournals()).",".
				convertAllMagazines2JSON(getMagazines()).",".
				convertAllChapters2JSON(getChapters()).",".
				convertAllProceedings2JSON(getProceedings()).",".
				convertAllReports2JSON(getReports()).",".
				convertAllPresentations2JSON(getPresentations()).",".
				convertAllMultimedia2JSON(getMultimedia()).
			"];";
		
		$str .= "papers = ".getPaperNames().";";
		$str .= "movies = ".getMultimediaNames().";";
		
		return $str;
	}

	if (!isset($_REQUEST) || !isset($_REQUEST["request"])) {
		exit;
	} else {
		foreach($_REQUEST as $key => $value) {
			$_REQUEST[$key] = stripslashes($value);
		}
	}

	if ($_REQUEST["request"] == "get_data") {
		echo getData();
	} else if ($_REQUEST["request"] == "move_entry_up") {
		moveEntryUp($_REQUEST["id"], $_REQUEST["part"]);
	} else if ($_REQUEST["request"] == "move_entry_down") {
		moveEntryDown($_REQUEST["id"], $_REQUEST["part"]);
	} else if ($_REQUEST["request"] == "remove_entry") {
		removeEntry($_REQUEST["id"], $_REQUEST["part"]);
	} else if ($_REQUEST["request"] == "insert_entry_after") {
		echo insertEntryAfter($_REQUEST["id"], $_REQUEST["part"]);
	} else if ($_REQUEST["request"] == "change_entry_year") {
		changeEntryYear($_REQUEST["id"], $_REQUEST["year"], $_REQUEST["part"]);
	} else if ($_REQUEST["request"] == "change_entry") {
		if ($_REQUEST["part"] == $JOURNAL_TYPE) {
		
			changeJournalEntry(
				$_REQUEST["id"], 
				split("[|]", $_REQUEST["authors"]),
				$_REQUEST["title"],
				$_REQUEST["journal"],
				$_REQUEST["year"],
				$_REQUEST["volume"],
				$_REQUEST["issue"],
				$_REQUEST["startPage"],
				$_REQUEST["endPage"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $MAGAZINE_TYPE) {
			changeMagazineEntry(
				$_REQUEST["id"], 
				split("[|]", $_REQUEST["authors"]),
				$_REQUEST["title"],
				$_REQUEST["magazine"],
				$_REQUEST["year"],
				$_REQUEST["volume"],
				$_REQUEST["issue"],
				$_REQUEST["startPage"],
				$_REQUEST["endPage"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $PROCEEDING_TYPE) {
			changeProceedingEntry(
				$_REQUEST["id"], 
				split("[|]", $_REQUEST["authors"]),
				$_REQUEST["title"],
				$_REQUEST["conference"],
				$_REQUEST["year"],
				$_REQUEST["startDate"],
				$_REQUEST["endDate"],
				$_REQUEST["place"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $MULTIMEDIA_TYPE) {
			changeMultimediaEntry(
				$_REQUEST["id"], 
				$_REQUEST["title"],
				$_REQUEST["year"],
				$_REQUEST["size"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $PRESENTATION_TYPE) {
			changePresentationEntry(
				$_REQUEST["id"], 
				$_REQUEST["title"],
				$_REQUEST["venue"],
				$_REQUEST["year"],
				$_REQUEST["date"],
				$_REQUEST["place"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $REPORT_TYPE) {
			changeReportEntry(
				$_REQUEST["id"], 
				split("[|]", $_REQUEST["authors"]),
				$_REQUEST["title"],
				$_REQUEST["institution"],
				$_REQUEST["year"],
				$_REQUEST["place"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		} else if ($_REQUEST["part"] == $CHAPTER_TYPE) {
			changeChapterEntry(
				$_REQUEST["id"], 
				split("[|]", $_REQUEST["authors"]),
				split("[|]", $_REQUEST["editors"]),
				$_REQUEST["title"],
				$_REQUEST["book"],
				$_REQUEST["year"],
				$_REQUEST["comment"],
				$_REQUEST["file"],
				$_REQUEST["entry"],
				$_REQUEST["url"],
				$_REQUEST["tag"]);
		}
	}
?>