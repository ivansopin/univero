<?php 
	function convertAllJournals2JSON($entries) {
		$str = "{type: \"journal\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertJournal2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertAllMagazines2JSON($entries) {
		$str = "{type: \"magazine\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertMagazine2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertAllProceedings2JSON($entries) {
		$str = "{type: \"proceeding\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertProceeding2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertAllMultimedia2JSON($entries) {
		$str = "{type: \"multimedia\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertMultimedia2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertAllPresentations2JSON($entries) {
		$str = "{type: \"presentation\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertPresentation2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}

	function convertAllReports2JSON($entries) {
		$str = "{type: \"report\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertReport2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertAllChapters2JSON($entries) {
		$str = "{type: \"chapter\", data: [";
		
		for ($i = 0; $i < sizeof($entries); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= convertChapter2JSON($entries[$i]);
		}
		
		$str .= "]}";
		
		return $str;
	}
	
	function convertJournal2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		
		$str .= "authors: [";
		
		for ($i = 0; $i < sizeof($entry["authors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["authors"][$i]."\"}";
		}
			
		$str .= "],";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "journal: \"".$entry["journal"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["volume"] != 0) {
			$str .= ",volume: ".$entry["volume"];	
		}
		
		if ($entry["issue"] != 0) {
			$str .= ",issue: ".$entry["issue"];	
		}
		
		if ($entry["start_page"] != 0) {
			$str .= ",startPage: ".$entry["start_page"];	
		}
		
		if ($entry["end_page"] != 0) {
			$str .= ",endPage: ".$entry["end_page"];	
		}
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}

	function convertMagazine2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		
		$str .= "authors: [";
		
		for ($i = 0; $i < sizeof($entry["authors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["authors"][$i]."\"}";
		}
			
		$str .= "],";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "magazine: \"".$entry["magazine"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["volume"] != 0) {
			$str .= ",volume: ".$entry["volume"];	
		}
		
		if ($entry["issue"] != 0) {
			$str .= ",issue: ".$entry["issue"];	
		}
		
		if ($entry["start_page"] != 0) {
			$str .= ",startPage: ".$entry["start_page"];	
		}
		
		if ($entry["end_page"] != 0) {
			$str .= ",endPage: ".$entry["end_page"];	
		}
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
	
	function convertProceeding2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		
		$str .= "authors: [";
		
		for ($i = 0; $i < sizeof($entry["authors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["authors"][$i]."\"}";
		}
			
		$str .= "],";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "conference: \"".$entry["conference"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["start_date"] != "") {
			$str .= ",startDate: \"".$entry["start_date"]."\"";		
		}
		
		if ($entry["end_date"] != "") {
			$str .= ",endDate: \"".$entry["end_date"]."\"";	
		}
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["place"] != "") {
			$str .= ",place: \"".$entry["place"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
	
	function convertMultimedia2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["size"] != 0) {
			$str .= ",size: ".$entry["size"];	
		}
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
	
	function convertPresentation2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "venue: \"".$entry["venue"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["date"] != "") {
			$str .= ",date: \"".$entry["date"]."\"";		
		}
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["place"] != "") {
			$str .= ",place: \"".$entry["place"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
	
	function convertReport2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		
		$str .= "authors: [";
		
		for ($i = 0; $i < sizeof($entry["authors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["authors"][$i]."\"}";
		}
			
		$str .= "],";
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "institution: \"".$entry["institution"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["place"] != "") {
			$str .= ",place: \"".$entry["place"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
	
	function convertChapter2JSON($entry) {
		$str = "{";
		
		$str .= "id: ".$entry["id"].",";
		
		$str .= "authors: [";
		
		for ($i = 0; $i < sizeof($entry["authors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["authors"][$i]."\"}";
		}
			
		$str .= "],";
		
		$str .= "editors: [";
		
		for ($i = 0; $i < sizeof($entry["editors"]); $i++) {
			if ($i != 0) {
				$str .= ",";
			}
			
			$str .= "{name: \"".$entry["editors"][$i]."\"}";
		}
			
		$str .= "],";
		
		$str .= "title: \"".$entry["title"]."\",";
		$str .= "book: \"".$entry["book"]."\",";
		$str .= "year: ".$entry["year"];
		
		if ($entry["comment"] != "") {
			$str .= ",comment: \"".$entry["comment"]."\"";	
		}
		
		if ($entry["file"] != "") {
			$str .= ",file: \"".$entry["file"]."\"";	
		}
		
		if ($entry["url"] != "") {
			$str .= ",url: \"".$entry["url"]."\"";	
		}
		
		if ($entry["tag"] != "") {
			$str .= ",tag: \"".$entry["tag"]."\"";	
		}
		
		if ($entry["entry"] != "") {
			$str .= ",entry: \"".$entry["entry"]."\"";	
		}
		
		$str .= "}";
		
		return $str;
	}
?>