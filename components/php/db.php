<?php
	include_once("settings.php");
	include_once("links.php");
	include_once("functions.php");
	include_once("sql.php");
	
	$REL_PATH_TO_DB = getRelativePath($DB, dirname($_SERVER["PHP_SELF"]), true).$DB_NAME.".db";

	function createTables($conn) {
		global $JOURNAL_CREATE;
		global $MAGAZINE_CREATE;
		global $CHAPTER_CREATE;
		global $MULTIMEDIA_CREATE;
		global $PRESENTATION_CREATE;
		global $PROCEEDING_CREATE;
		global $REPORT_CREATE;
		global $AUTHOR_CREATE;
		global $EDITOR_CREATE;
		
		$conn->query($JOURNAL_CREATE);
		$conn->query($MAGAZINE_CREATE);
		$conn->query($CHAPTER_CREATE);
		$conn->query($MULTIMEDIA_CREATE);
		$conn->query($PRESENTATION_CREATE);
		$conn->query($PROCEEDING_CREATE);
		$conn->query($REPORT_CREATE);
		$conn->query($AUTHOR_CREATE);
		$conn->query($EDITOR_CREATE);
	}
	
	function lastInsertId($conn) {
		$result = $conn->query("SELECT last_insert_rowid() AS last_insert_rowid")->fetch();
		return $result["last_insert_rowid"];
	}
	
	
	function getConnection() {
		global $REL_PATH_TO_DB;

		$newDB = false;
		
		if (!file_exists($REL_PATH_TO_DB)) {
			$newDB = true;
		}
		
		$conn = new PDO("sqlite:".$REL_PATH_TO_DB);
		
		if ($newDB) {
			createTables($conn);
		}
		
		return $conn;
	}

	function getDBInfo() {
		global $REL_PATH_TO_DB;
		
		if (!file_exists($REL_PATH_TO_DB)) {
			return null;
		}
		
		$conn = new PDO("sqlite:".$REL_PATH_TO_DB);

		if (!$conn) {
			return null;
		}

		$entries = null;
		
		$count = 0;
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM chapter");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM journal");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM magazine");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM multimedia");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM presentation");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM proceeding");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$rs = $conn->query("
			SELECT COUNT(*) AS count
			FROM report");
		
		if ($data = $rs->fetch()) {
			$count += $data["count"];			
		}
		
		$db_info;
		
		$db_info["count"] = $count;
		
		return $db_info;
	}
	
	function getTaggedEntries($tags) {
		$all_entries;
		
		$all_entries[0]["type"] = "JOURNALS";
		$all_entries[0]["data"] = getEntriesOfType("journal", $tags);
		
		$all_entries[1]["type"] = "MAGAZINES";
		$all_entries[1]["data"] = getEntriesOfType("magazine", $tags);
		
		$all_entries[2]["type"] = "BOOK CHAPTERS";
		$all_entries[2]["data"] = getEntriesOfType("chapter", $tags);
		
		$all_entries[3]["type"] = "PROCEEDINGS";
		$all_entries[3]["data"] = getEntriesOfType("proceeding", $tags);
		
		$all_entries[4]["type"] = "TECHNICAL REPORTS";
		$all_entries[4]["data"] = getEntriesOfType("report", $tags);
		
		$all_entries[5]["type"] = "PRESENTATIONS";
		$all_entries[5]["data"] = getEntriesOfType("presentation", $tags);
		
		$all_entries[6]["type"] = "MULTIMEDIA";
		$all_entries[6]["data"] = getEntriesOfType("multimedia", $tags);
		
		return $all_entries;
	}
	
	function getAllEntries() {
		$all_entries;
		
		$all_entries[0]["type"] = "JOURNALS";
		$all_entries[0]["data"] = getEntriesOfType("journal", null);
		
		$all_entries[1]["type"] = "MAGAZINES";
		$all_entries[1]["data"] = getEntriesOfType("magazine", null);
		
		$all_entries[2]["type"] = "BOOK CHAPTERS";
		$all_entries[2]["data"] = getEntriesOfType("chapter", null);
		
		$all_entries[3]["type"] = "PROCEEDINGS";
		$all_entries[3]["data"] = getEntriesOfType("proceeding", null);
		
		$all_entries[4]["type"] = "TECHNICAL REPORTS";
		$all_entries[4]["data"] = getEntriesOfType("report", null);
		
		$all_entries[5]["type"] = "PRESENTATIONS";
		$all_entries[5]["data"] = getEntriesOfType("presentation", null);
		
		$all_entries[6]["type"] = "MULTIMEDIA";
		$all_entries[6]["data"] = getEntriesOfType("multimedia", null);
		
		return $all_entries;
	}
	
	function getEntriesOfType($type, $tags) {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$condition = "";
		
		$l = sizeof($tags);
		
		if ($tags != null && $l != 0) {
			$condition = "WHERE ";
			
			for ($i = 0; $i < $l; $i++) {				
				if ($i != 0) {
					$condition .= " OR ";
				}
				
				$condition .= "tag LIKE '%".$tags[$i]."%'";
			}
			
			$condition .= " ";
		}
		
		$rs = $conn->query("
			SELECT id, year, tag, entry
			FROM ".$type." ".
			$condition.
			"ORDER BY year DESC, 
				sequence");
		
		$entries = null;
			
		$i = 0;
		
		while ($data = $rs->fetch()) {
			$entries[$i]["id"] = $data["id"];			
			$entries[$i]["year"] = $data["year"];
			$entries[$i]["tag"] = $data["tag"];
			$entries[$i]["entry"] = $data["entry"];
			
			$i++;
		}
		
		$conn = null;
		
		return $entries;
	}

	function getTags() {
		$tags = getAllTags();
		
		$unique_tags = array();
		$current_tags;
		$current_tag;
		
		$l = sizeof($tags);
		
		for ($i = 0; $i < $l; $i++) {
			$current_tags = split("[,]", $tags[$i]);
			
			$m = sizeof($current_tags);
			
			for ($j = 0; $j < $m; $j++) {
				$current_tag = trim($current_tags[$j]); 
				
				if ($current_tag == "") {
					continue;
				}
				
				$n = sizeof($unique_tags);
				$new_tag = true;
				
				for ($k = 0; $k < $n; $k++) {
					if ($unique_tags[$k] == $current_tag) {
						$new_tag = false;
						break;
					}
				}
				
				if ($new_tag) {
					$unique_tags[$n] = $current_tag;
				}
			}	
		}
		
		return $unique_tags;
	}
	
	function getAllTags() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$tags;
		
		$rs = $conn->query("
			SELECT DISTINCT tag
			FROM (
				SELECT DISTINCT tag 
				FROM journal
				
				UNION
				
				SELECT DISTINCT tag 
				FROM magazine
				
				UNION
				
				SELECT DISTINCT tag 
				FROM proceeding
				
				UNION
				
				SELECT DISTINCT tag 
				FROM multimedia
				
				UNION
				
				SELECT DISTINCT tag 
				FROM presentation
				
				UNION
				
				SELECT DISTINCT tag 
				FROM report
				
				UNION
				
				SELECT DISTINCT tag 
				FROM chapter
			) 
			WHERE tag != ''");
		
		$entries = null;
			
		$i = 0;
		
		while ($data = $rs->fetch()) {
			$entries[$i] = $data["tag"];
			
			$i++;
		}
		
		$conn = null;
		
		return $entries;
	}
	
	
	function getJournals() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM journal j, author a  
			WHERE a.entry_id = j.id 
				AND a.entry_type = 'journal' 
			ORDER BY j.year DESC, 
				j.sequence");
		
		$entries = null;
		$authors;
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries[$i]["authors"] = $authors;
				}
				
				$i++;
				
				$authors = array($data["name"]);
				
				$entries[$i]["id"] = $data["id"];
				$entries[$i]["title"] = $data["title"];
				$entries[$i]["journal"] = $data["journal"];
				$entries[$i]["year"] = $data["year"];
				$entries[$i]["volume"] = $data["volume"];
				$entries[$i]["issue"] = $data["issue"];
				$entries[$i]["start_page"] = $data["start_page"];
				$entries[$i]["end_page"] = $data["end_page"];
				$entries[$i]["comment"] = $data["comment"];
				$entries[$i]["file"] = $data["file"];
				$entries[$i]["entry"] = $data["entry"];
				$entries[$i]["url"] = $data["url"];
				$entries[$i]["tag"] = $data["tag"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($authors);
				$authors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries[$i]["authors"] = $authors;
		}

		$conn = null;
		
		return $entries;
	}
	
	function getMagazines() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM magazine m, author a  
			WHERE a.entry_id = m.id 
				AND a.entry_type = 'magazine' 
			ORDER BY m.year DESC, 
				m.sequence");
		
		$entries = null;
		$authors;
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries[$i]["authors"] = $authors;
				}
				
				$i++;
				
				$authors = array($data["name"]);
				
				$entries[$i]["id"] = $data["id"];
				$entries[$i]["title"] = $data["title"];
				$entries[$i]["magazine"] = $data["magazine"];
				$entries[$i]["year"] = $data["year"];
				$entries[$i]["volume"] = $data["volume"];
				$entries[$i]["issue"] = $data["issue"];
				$entries[$i]["start_page"] = $data["start_page"];
				$entries[$i]["end_page"] = $data["end_page"];
				$entries[$i]["comment"] = $data["comment"];
				$entries[$i]["file"] = $data["file"];
				$entries[$i]["entry"] = $data["entry"];
				$entries[$i]["url"] = $data["url"];
				$entries[$i]["tag"] = $data["tag"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($authors);
				$authors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries[$i]["authors"] = $authors;
		}

		$conn = null;
		
		return $entries;
	}
	
	function getProceedings() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM proceeding p, author a  
			WHERE a.entry_id = p.id 
				AND a.entry_type = 'proceeding' 
			ORDER BY p.year DESC, 
				p.sequence");
		
		$entries = null;
		$authors;
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries[$i]["authors"] = $authors;
				}
				
				$i++;
				
				$authors = array($data["name"]);
				
				$entries[$i]["id"] = $data["id"];
				$entries[$i]["title"] = $data["title"];
				$entries[$i]["conference"] = $data["conference"];
				$entries[$i]["year"] = $data["year"];
				$entries[$i]["start_date"] = $data["start_date"];
				$entries[$i]["end_date"] = $data["end_date"];
				$entries[$i]["place"] = $data["place"];
				$entries[$i]["comment"] = $data["comment"];
				$entries[$i]["file"] = $data["file"];
				$entries[$i]["entry"] = $data["entry"];
				$entries[$i]["url"] = $data["url"];
				$entries[$i]["tag"] = $data["tag"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($authors);
				$authors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries[$i]["authors"] = $authors;
		}

		$conn = null;
		
		return $entries;
	}

	function getMultimedia() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM multimedia   
			ORDER BY year DESC, 
				sequence");
		
		$entries = null;
			
		$i = 0;
		
		while ($data = $rs->fetch()) {
			$entries[$i]["id"] = $data["id"];
			$entries[$i]["title"] = $data["title"];
			$entries[$i]["year"] = $data["year"];
			$entries[$i]["size"] = $data["size"];
			$entries[$i]["comment"] = $data["comment"];
			$entries[$i]["file"] = $data["file"];
			$entries[$i]["entry"] = $data["entry"];
			$entries[$i]["url"] = $data["url"];
			$entries[$i]["tag"] = $data["tag"];

			$i++;
		}

		$conn = null;
		
		return $entries;
	}
	
	function getPresentations() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM presentation   
			ORDER BY year DESC, 
				sequence");
		
		$entries = null;
			
		$i = 0;
		
		while ($data = $rs->fetch()) {
			$entries[$i]["id"] = $data["id"];
			$entries[$i]["title"] = $data["title"];
			$entries[$i]["venue"] = $data["venue"];
			$entries[$i]["year"] = $data["year"];
			$entries[$i]["date"] = $data["date"];
			$entries[$i]["place"] = $data["place"];
			$entries[$i]["comment"] = $data["comment"];
			$entries[$i]["file"] = $data["file"];
			$entries[$i]["entry"] = $data["entry"];
			$entries[$i]["url"] = $data["url"];
			$entries[$i]["tag"] = $data["tag"];

			$i++;
		}

		$conn = null;
		
		return $entries;
	}
	
	function getReports() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT * 
			FROM report r, author a 
			WHERE a.entry_id = r.id 
				AND a.entry_type = 'report' 
			ORDER BY r.year DESC, 
				r.sequence");
			
		$entries = null;
		$authors;
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries[$i]["authors"] = $authors;
				}
				
				$i++;
				
				$authors = array($data["name"]);
				
				$entries[$i]["id"] = $data["id"];
				$entries[$i]["title"] = $data["title"];
				$entries[$i]["institution"] = $data["institution"];
				$entries[$i]["year"] = $data["year"];
				$entries[$i]["place"] = $data["place"];
				$entries[$i]["comment"] = $data["comment"];
				$entries[$i]["file"] = $data["file"];
				$entries[$i]["entry"] = $data["entry"];
				$entries[$i]["url"] = $data["url"];
				$entries[$i]["tag"] = $data["tag"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($authors);
				$authors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries[$i]["authors"] = $authors;
		}

		$conn = null;
		
		return $entries;
	}
	
	function getChapters() {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$entries = null;
		$entries2 = null;
		$authors;
		$editors;
		
		$rs = $conn->query("
			SELECT * 
			FROM chapter c, author a 
			WHERE a.entry_id = c.id 
				AND a.entry_type = 'chapter' 
			ORDER BY c.year DESC, 
				c.sequence");
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries[$i]["authors"] = $authors;
				}
				
				$i++;
				
				$authors = array($data["name"]);
				
				$entries[$i]["id"] = $data["id"];
				$entries[$i]["title"] = $data["title"];
				$entries[$i]["book"] = $data["book"];
				$entries[$i]["year"] = $data["year"];
				$entries[$i]["comment"] = $data["comment"];
				$entries[$i]["file"] = $data["file"];
				$entries[$i]["entry"] = $data["entry"];
				$entries[$i]["url"] = $data["url"];
				$entries[$i]["tag"] = $data["tag"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($authors);
				$authors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries[$i]["authors"] = $authors;
		}
		
		$rs = $conn->query("
			SELECT c.id, e.* 
			FROM chapter c, editor e 
			WHERE e.entry_id = c.id 
				AND e.entry_type = 'chapter' 
			ORDER BY c.year DESC, 
				c.sequence");
			
		$i = -1;
		$prev_id = -1;
		
		while ($data = $rs->fetch()) {			
			if ($data["id"] != $prev_id) {
				if ($i != -1) {
					$entries2[$i]["editors"] = $editors;
				}
				
				$i++;
				
				$editors = array($data["name"]);
				
				$entries2[$i]["id"] = $data["id"];

				$prev_id = $data["id"];
			} else {
				$l = sizeof($editors);
				$editors[$l] = $data["name"];
			}
		}
		
		if ($prev_id != -1) {
			$entries2[$i]["editors"] = $editors;
		}
		
		$conn = null;
		
		$l = sizeof($entries);
		$m = sizeof($entries2);
		
		for ($i = 0; $i < $l; $i++) {
			$entries[$i]["editors"] = array();
			
			for ($j = 0; $j < $m; $j++) {
				if ($entries[$i]["id"] == $entries2[$j]["id"]) {
					$entries[$i]["editors"] = $entries2[$j]["editors"];
					break; 
				}
			}
		}
		
		return $entries;
	}
	
	function moveEntryUp($id, $type) {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT sequence, year 
			FROM ".$type."   
			WHERE id = ".$id." 
			LIMIT 1");

		$sequence;
		$year;
			
		if ($data = $rs->fetch()) {			
			$sequence = $data["sequence"];
			$year = $data["year"];
		}
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence + 1   
			WHERE sequence = ".($sequence - 1)."
				AND year = ".$year);
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence - 1   
			WHERE id = ".$id);
			
		$conn = null;
	}
	
	function moveEntryDown($id, $type) {
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT sequence, year 
			FROM ".$type."   
			WHERE id = ".$id." 
			LIMIT 1");

		$sequence;
		$year;
			
		if ($data = $rs->fetch()) {			
			$sequence = $data["sequence"];
			$year = $data["year"];
		}
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence - 1   
			WHERE sequence = ".($sequence + 1)."
				AND year = ".$year);
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence + 1 
			WHERE id = ".$id);
			
		$conn = null;
	}
	
	function removeEntry($id, $type) {
		global $JOURNAL_TYPE;
		global $MAGAZINE_TYPE;
		global $PROCEEDING_TYPE;
		global $MULTIMEDIA_TYPE;
		global $PRESENTATION_TYPE;
		global $REPORT_TYPE;
		global $CHAPTER_TYPE;
		
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT sequence, year 
			FROM ".$type."   
			WHERE id = ".$id." 
			LIMIT 1");

		$sequence;
		$year;
			
		if ($data = $rs->fetch()) {			
			$sequence = $data["sequence"];
			$year = $data["year"];
		}
		
		$conn->query("
			DELETE FROM ".$type." 
			WHERE id = ".$id);
			
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence - 1 
			WHERE sequence > ".$sequence."
				AND year = ".$year);
			
		if ($type == $JOURNAL_TYPE || 
			$type == $MAGAZINE_TYPE ||
			$type == $PROCEEDING_TYPE ||
			$type == $REPORT_TYPE ||
			$type == $CHAPTER_TYPE) {
				
			$conn->query("
				DELETE FROM author 
				WHERE entry_id = ".$id."
					AND entry_type = '".$type."'");
		}
		
		if ($type == $CHAPTER_TYPE) {
			$conn->query("
				DELETE FROM editor 
				WHERE entry_id = ".$id."
					AND entry_type = '".$type."'");
		}
		
		$conn = null;
	}
	
	function insertEntryAfter($id, $type) {
		global $NEW_TITLE;
		
		global $NEW_JOURNAL;
		global $NEW_MAGAZINE;
		global $NEW_PROCEEDING;
		global $NEW_PRESENTATION;
		global $NEW_REPORT;
		global $NEW_CHAPTER;
		
		global $NEW_AUTHOR;
		global $NEW_EDITOR;
		
		global $JOURNAL_TYPE;
		global $MAGAZINE_TYPE;
		global $PROCEEDING_TYPE;
		global $MULTIMEDIA_TYPE;
		global $PRESENTATION_TYPE;
		global $REPORT_TYPE;
		global $CHAPTER_TYPE;
		
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT sequence, year 
			FROM ".$type."    
			WHERE id = ".$id." 
			LIMIT 1");

		$sequence = 0;
		$year = (int)date("Y");
			
		if ($data = $rs->fetch()) {			
			$sequence = $data["sequence"];
			$year = $data["year"];
		}
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence + 1 
			WHERE sequence > ".$sequence."
				AND year = ".$year);
		
		$query;
		
		if ($type == $JOURNAL_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_JOURNAL."',
					".$year.",
					0,
					0,
					0,
					0,
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $MAGAZINE_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_MAGAZINE."',
					".$year.",
					0,
					0,
					0,
					0,
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $PROCEEDING_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_PROCEEDING."',
					".$year.",
					'',
					'',
					'',
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $MULTIMEDIA_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					".$year.",
					0,
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $PRESENTATION_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_PRESENTATION."',
					".$year.",
					'',
					'',
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $REPORT_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_REPORT."',
					".$year.",
					'',
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		} else if ($type == $CHAPTER_TYPE) {
			$query = "
				INSERT INTO ".$type."
				VALUES(
					NULL,
					'".$NEW_TITLE."',
					'".$NEW_CHAPTER."',
					".$year.",
					'',
					'',
					".($sequence + 1).",
					'',
					'',
					'')";
		}
		
		$conn->query($query);
		
		$lastInsertId = $conn->lastInsertId();
		
		if ($type == $JOURNAL_TYPE || 
			$type == $MAGAZINE_TYPE ||
			$type == $PROCEEDING_TYPE ||
			$type == $REPORT_TYPE ||
			$type == $CHAPTER_TYPE) {
			$conn->query("
				INSERT INTO author
				VALUES(
					".$lastInsertId.",
					'".$type."',
					'".$NEW_AUTHOR."',
					0)");
		}

		if ($type == $CHAPTER_TYPE) {
			$conn->query("
				INSERT INTO editor
				VALUES(
					".$lastInsertId.",
					'".$type."',
					'".$NEW_EDITOR."',
					0)");
		}
		
		$conn = null;
		
		return $lastInsertId;
	}
	
	function changeEntryYear($id, $toYear, $type) {	
		$conn = getConnection();
		
		if (!$conn) {
			return;
		}
		
		$rs = $conn->query("
			SELECT sequence, year 
			FROM ".$type."   
			WHERE id = ".$id." 
			LIMIT 1");

		$sequence;
		$year;
			
		if ($data = $rs->fetch()) {			
			$sequence = $data["sequence"];
			$year = $data["year"];
		}
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence - 1 
			WHERE sequence > ".$sequence."
				AND year = ".$year);
		
		$conn->query("
			UPDATE ".$type." 
			SET sequence = sequence + 1 
			WHERE year = ".$toYear);
			
		$conn->query("
			UPDATE ".$type." 
			SET year = ".$toYear.",
				sequence = 0  
			WHERE id = ".$id);
		
		$conn = null;
	}

	function changeJournalEntry($id, $authors, $title, $journal, $year, $volume, 
		$issue, $startPage, $endPage, $comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();

		if ($volume == "") {
			$volume = 0;
		}
		
		if ($issue == "") {
			$issue = 0;
		}
		
		if ($startPage == "") {
			$startPage = 0;
		}
		
		if ($endPage == "") {
			$endPage = 0;
		}
		
		$stmt = $conn->prepare("
			UPDATE journal 
			SET title = :title,
				journal = :journal,
				year = :year, 
				volume = :volume,
				issue = :issue, 
				start_page = :start_page, 
				end_page = :end_page,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
		
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':journal', $journal, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':volume', $volume, PDO::PARAM_INT);
		$stmt->bindValue(':issue', $issue, PDO::PARAM_INT);
		$stmt->bindValue(':start_page', $startPage, PDO::PARAM_INT);
		$stmt->bindValue(':end_page', $endPage, PDO::PARAM_INT);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn->query("
			DELETE FROM author 
			WHERE entry_id = ".$id."
				AND entry_type = 'journal'");
		
		$i = 0;
			
		
		$stmt = $conn->prepare("
			INSERT INTO author
			VALUES(:id, 'journal', :value, :i)");
		
		foreach($authors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$i++;
		}
		
				
		$stmt = null;
		
		$conn = null;
	}

	function changeMagazineEntry($id, $authors, $title, $magazine, $year, $volume, 
		$issue, $startPage, $endPage, $comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();

		if ($volume == "") {
			$volume = 0;
		}
		
		if ($issue == "") {
			$issue = 0;
		}
		
		if ($startPage == "") {
			$startPage = 0;
		}
		
		if ($endPage == "") {
			$endPage = 0;
		}
			
		$stmt = $conn->prepare("
			UPDATE magazine 
			SET title = :title,
				magazine = :magazine,
				year = :year, 
				volume = :volume,
				issue = :issue, 
				start_page = :start_page, 
				end_page = :end_page,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
		
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':magazine', $magazine, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':volume', $volume, PDO::PARAM_INT);
		$stmt->bindValue(':issue', $issue, PDO::PARAM_INT);
		$stmt->bindValue(':start_page', $startPage, PDO::PARAM_INT);
		$stmt->bindValue(':end_page', $endPage, PDO::PARAM_INT);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn->query("
			DELETE FROM author 
			WHERE entry_id = ".$id."
				AND entry_type = 'magazine'");
		
		$i = 0;
			
		
		$stmt = $conn->prepare("
			INSERT INTO author
			VALUES(:id, 'magazine', :value, :i)");
		
		foreach($authors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$i++;
		}
		
				
		$stmt = null;
		
		$conn = null;
	}
	
	function changeProceedingEntry($id, $authors, $title, $conference, $year, 
		$startDate, $endDate, $place, $comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();
			
		$stmt = $conn->prepare("
			UPDATE proceeding 
			SET title = :title,
				conference = :conference,
				year = :year, 
				start_date = :start_date, 
				end_date = :end_date,
				place = :place,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
		
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':conference', $conference, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':start_date', $startDate, PDO::PARAM_INT);
		$stmt->bindValue(':end_date', $endDate, PDO::PARAM_INT);
		$stmt->bindValue(':place', $place, PDO::PARAM_STR);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn->query("
			DELETE FROM author 
			WHERE entry_id = ".$id."
				AND entry_type = 'proceeding'");
		
		$i = 0;
			
		
		$stmt = $conn->prepare("
			INSERT INTO author
			VALUES(:id, 'proceeding', :value, :i)");
		
		foreach($authors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$i++;
		}
		
				
		$stmt = null;
		
		$conn = null;
	}
	
	function changeMultimediaEntry($id, $title, $year, $size, 
		$comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();

		if ($size == "") {
			$size = 0;
		}
			
		$stmt = $conn->prepare("
			UPDATE multimedia 
			SET title = :title,
				year = :year, 
				size = :size,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
		
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':size', $size, PDO::PARAM_INT);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn = null;
	}
	
	function changePresentationEntry($id, $title, $venue, $year, 
		$date, $place, $comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();
			
		$stmt = $conn->prepare("
			UPDATE presentation 
			SET title = :title,
				venue = :venue,
				year = :year, 
				date = :date, 
				place = :place,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
			
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':venue', $venue, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':date', $date, PDO::PARAM_STR);
		$stmt->bindValue(':place', $place, PDO::PARAM_STR);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->execute();
		
		$stmt = null;
		
		$conn = null;
	}
	
	function changeReportEntry($id, $authors, $title, $institution, 
		$year, $place, $comment, $file, $entry, $url, $tag) {		

		$conn = getConnection();
			
		$stmt = $conn->prepare("
			UPDATE report 
			SET title = :title,
				institution = :institution,
				year = :year, 
				place = :place,
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");

		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':institution', $institution, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':place', $place, PDO::PARAM_STR);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn->query("
			DELETE FROM author 
			WHERE entry_id = ".$id."
				AND entry_type = 'report'");
		
		$i = 0;
			
		
		$stmt = $conn->prepare("
			INSERT INTO author
			VALUES(:id, 'report', :value, :i)");
		
		foreach($authors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$i++;
		}
		
				
		$stmt = null;
		
		$conn = null;
	}
	
	function changeChapterEntry($id, $authors, $editors, $title, $book, 
		$year, $comment, $file, $entry, $url, $tag) {

		$conn = getConnection();
			
		$stmt = $conn->prepare("
			UPDATE chapter 
			SET title = :title,
				book = :book,
				year = :year, 
				comment = :comment,
				file = :file,
				entry = :entry,
				url = :url,
				tag = :tag
			WHERE id = :id");
		
		$stmt->bindValue(':title', $title, PDO::PARAM_STR);
		$stmt->bindValue(':book', $book, PDO::PARAM_STR);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':file', $file, PDO::PARAM_STR);
		$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);
		$stmt->bindValue(':url', $url, PDO::PARAM_STR);
		$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
		$stmt->execute();
		
		$stmt = null;
		
		$conn->query("
			DELETE FROM author 
			WHERE entry_id = ".$id."
				AND entry_type = 'chapter'");
			
		$conn->query("
			DELETE FROM editor 
			WHERE entry_id = ".$id."
				AND entry_type = 'chapter'");
		
		$i = 0;
					
		$stmt = $conn->prepare("
			INSERT INTO author
			VALUES(:id, 'chapter', :value, :i)");
		
		foreach($authors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
			
			$stmt->execute();
			
			$i++;
		}
				
		$stmt = null;
		
		$i = 0;
					
		$stmt = $conn->prepare("
			INSERT INTO editor
			VALUES(:id, 'chapter', :value, :i)");
		
		foreach($editors as $key => $value) {
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':value', $value, PDO::PARAM_STR);
			$stmt->bindValue(':i', $i, PDO::PARAM_INT);
		
			
			$stmt->execute();
			
			$i++;
		}
				
		$stmt = null;
		
		$conn = null;
	}
?>