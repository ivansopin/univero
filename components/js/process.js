var data;
var papers;
var movies;

var URL = PHP + "/controller.php";

// if AJAX is not supported, redirect to the root 
if (!request) { 
	document.location.href = "/felix";
}

function insertRow(name, index, caption, text, id, length, onblur) {
	var row = $(name).insertRow(index);

	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	
	cell1.className = "caption";
	cell2.className = "editable";

	cell1.innerHTML = caption + ": ";
	cell2.innerHTML = "<input " +
			"id=\"" + id + "\" " +
			"maxlength=\"" + length + "\" " +
			"onblur=\"" + onblur + "\" " + 
			"value=\"" + ((text == null) ? "" : text) + "\" />";
			
	cell2.colSpan = "2";
}

function insertCombo(name, index, caption, text, id, onchange, type) {
	var typeData = null;
	
	if (type == "papers") {
		typeData = papers;
	} else if (type == "movies") {
		typeData = movies;
	}
	
	if (typeData != null) {
		var row = $(name).insertRow(index);
	
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		
		cell1.className = "caption";
		cell2.className = "editable";
		
		cell1.innerHTML = caption + ": ";
		cell2.innerHTML = "<select id=\"" + id + "\" onchange=\"" + onchange + "\" />";
		
		var select = $(id);
		
		var matchExist = false;
		
		for (var i = 0; i <= typeData.length; i++) {
			var x = document.createElement("option");
			
			if (i == 0) {
				x.text = "";
			} else {
				x.text = typeData[i - 1];
			}
			
			try {
				select.add(x, null);
			} catch (failed) {
				select.add(x);
			}
			
			if (typeData[i - 1] == text) {
				select.selectedIndex = i;
				
				matchExist = true;
			}
		}
		
		if (!matchExist) {
			select.selectedIndex = 0;
		}
		
		cell2.colSpan = "2";
	}
}

function getDataPart(part) {
	var l = data.length;
	
	for (var i = 0; i < l; i++) {
		if (data[i].type == part) {
			return data[i].data;
		}
	}
	
	return null;
}

function populateDataPartTable(tableIndex, part) {
	var dataPart = getDataPart(part);
	
	var name = part + tableIndex;
	
	var row;
	
	var cell1;
	var cell2;
	var cell3;

	while ($(name).rows.length > 0) {
		$(name).deleteRow(0);
	}
	
	var l = 0;
	
	var offset;
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == REPORT_TYPE || 
			part == CHAPTER_TYPE	) {
			
		l = dataPart[tableIndex].authors.length;
		
		offset = l;
		
		for (var i = 0; i < l; i++) {
			row = $(name).insertRow(i);
	
			cell1 = row.insertCell(0);
			cell2 = row.insertCell(1);
			cell3 = row.insertCell(2);
			
			cell1.className = "caption";
			cell3.className = "buttons";
	
			cell1.innerHTML = "Author: ";
			cell2.innerHTML = "<input type=\"text\" id=\"" + (part + tableIndex + "Author" + i) + "\" onblur=\"checkDataPartAuthor(this.id, this.value, " + tableIndex + ", " + i + ",'" + part + "');\" maxlength=\"80\" value=\"" + dataPart[tableIndex].authors[i].name + "\" />";
			cell3.innerHTML = 
				(i == 0 ?
					"<span class=\"toggleInactive\">[&uarr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveAuthorUp(" + tableIndex + ", " + i + ", '" + part + "');\">[&uarr;]</span>"
				) +
				
				"&nbsp;" +
				
				(i == l - 1 ?
					"<span class=\"toggleInactive\">[&darr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveAuthorDown(" + tableIndex + ", " + i + ", '" + part + "');\">[&darr;]</span>"
				) +
				
				"&nbsp;" +
	
				(l == 1 ?
					"<span class=\"toggleInactive\">[&ndash;]</span>"
				:
					"<span class=\"toggle\" onclick=\"removeAuthor(" + tableIndex + ", " + i + ", '" + part + "', true);\">[&ndash;]</span>"
				) +
				
				"&nbsp;" +
				
				"<span class=\"toggle\" onclick=\"insertAuthorAfter(" + tableIndex + ", " + i + ", '" + part + "');\">[\\/]</span>";
		}
	}
	
	if (part == CHAPTER_TYPE) {
			
		l = dataPart[tableIndex].editors.length;
		
		for (var i = 0; i < l; i++) {
			row = $(name).insertRow(i + offset);
	
			cell1 = row.insertCell(0);
			cell2 = row.insertCell(1);
			cell3 = row.insertCell(2);
			
			cell1.className = "caption";
			cell3.className = "buttons";
	
			cell1.innerHTML = "Editor: ";
			cell2.innerHTML = "<input type=\"text\" id=\"" + (part + tableIndex + "Editor" + i) + "\" onblur=\"checkDataPartEditor(this.id, this.value, " + tableIndex + ", " + i + ",'" + part + "');\" maxlength=\"80\" value=\"" + dataPart[tableIndex].editors[i].name + "\" />";
			cell3.innerHTML = 
				(i == 0 ?
					"<span class=\"toggleInactive\">[&uarr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveEditorUp(" + tableIndex + ", " + i + ", '" + part + "');\">[&uarr;]</span>"
				) +
				
				"&nbsp;" +
				
				(i == l - 1 ?
					"<span class=\"toggleInactive\">[&darr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveEditorDown(" + tableIndex + ", " + i + ", '" + part + "');\">[&darr;]</span>"
				) +
				
				"&nbsp;" +
	
				(l == 1 ?
					"<span class=\"toggleInactive\">[&ndash;]</span>"
				:
					"<span class=\"toggle\" onclick=\"removeEditor(" + tableIndex + ", " + i + ", '" + part + "', true);\">[&ndash;]</span>"
				) +
				
				"&nbsp;" +
				
				"<span class=\"toggle\" onclick=\"insertEditorAfter(" + tableIndex + ", " + i + ", '" + part + "');\">[\\/]</span>";
		}
		
		l += offset;
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertRow(name, l++, "Title", dataPart[tableIndex].title, (part + tableIndex) + "Title", 200, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'title', '" + part + "');");
	}
	
	if (part == JOURNAL_TYPE) {
		insertRow(name, l++, "Journal", dataPart[tableIndex].journal, (part + tableIndex) + "Journal", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'journal', '" + part + "');");
	}
	
	if (part == MAGAZINE_TYPE) {
		insertRow(name, l++, "Magazine", dataPart[tableIndex].magazine, (part + tableIndex) + "Magazine", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'magazine', '" + part + "');");
	}
	
	if (part == PROCEEDING_TYPE) {
		insertRow(name, l++, "Conference", dataPart[tableIndex].conference, (part + tableIndex) + "Conference", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'conference', '" + part + "');");
	}
	
	if (part == PRESENTATION_TYPE) {
		insertRow(name, l++, "Venue", dataPart[tableIndex].venue, (part + tableIndex) + "Venue", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'venue', '" + part + "');");
	}
	
	if (part == REPORT_TYPE) {
		insertRow(name, l++, "Institution", dataPart[tableIndex].institution, (part + tableIndex) + "Institution", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'institution', '" + part + "');");		
	}
	
	if (part == CHAPTER_TYPE) {
		insertRow(name, l++, "Book", dataPart[tableIndex].book, (part + tableIndex) + "Book", 150, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'book', '" + part + "');");		
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertRow(name, l++, "Year", dataPart[tableIndex].year, (part + tableIndex) + "Year", 4, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'year', '" + part + "');");
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		insertRow(name, l++, "Volume", dataPart[tableIndex].volume, (part + tableIndex) + "Volume", 4, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'volume', '" + part + "');");
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		insertRow(name, l++, "Issue", dataPart[tableIndex].issue, (part + tableIndex) + "Issue", 4, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'issue', '" + part + "');");
	}
	
	if (part == MULTIMEDIA_TYPE) {
		insertRow(name, l++, "Size&nbsp;(MB)", dataPart[tableIndex].size, (part + tableIndex) + "Size", 4, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'size', '" + part + "');");
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		insertRow(name, l++, "Start&nbsp;Page", dataPart[tableIndex].startPage, (part + tableIndex) + "StartPage", 5, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'startPage', '" + part + "');");
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		insertRow(name, l++, "End&nbsp;Page", dataPart[tableIndex].endPage, (part + tableIndex) + "EndPage", 5, "checkDataPartNumber(this.id, this.value, " + tableIndex + ", 'endPage', '" + part + "');");
	}
	
	if (part == PROCEEDING_TYPE) {
		insertRow(name, l++, "Start&nbsp;Date", dataPart[tableIndex].startDate, (part + tableIndex) + "StartDate", 5, "checkDataPartDate(this.id, this.value, " + tableIndex + ", 'startDate', '" + part + "');");
	}
	
	if (part == PROCEEDING_TYPE) {
		insertRow(name, l++, "End&nbsp;Date", dataPart[tableIndex].endDate, (part + tableIndex) + "EndDate", 5, "checkDataPartDate(this.id, this.value, " + tableIndex + ", 'endDate', '" + part + "');");
	}
	
	if (part == PRESENTATION_TYPE) {
		insertRow(name, l++, "Date", dataPart[tableIndex].date, (part + tableIndex) + "Date", 5, "checkDataPartDate(this.id, this.value, " + tableIndex + ", 'date', '" + part + "');");
	}
	
	if (part == PROCEEDING_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE) {
		insertRow(name, l++, "Place", dataPart[tableIndex].place, (part + tableIndex) + "Place", 50, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'place', '" + part + "');");
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertRow(name, l++, "Comment", dataPart[tableIndex].comment, (part + tableIndex) + "Comment", 50, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'comment', '" + part + "');");
	} else if (part == MULTIMEDIA_TYPE) {
		insertRow(name, l++, "Comment", dataPart[tableIndex].comment, (part + tableIndex) + "Comment", 200, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'comment', '" + part + "');");
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertCombo(name, l++, "File", dataPart[tableIndex].file, (part + tableIndex) + "File", "checkDataPartFile(this.id, this.options[this.selectedIndex].innerHTML, " + tableIndex + ", '" + part + "');", "papers");
	} else if (part == MULTIMEDIA_TYPE) {
		insertCombo(name, l++, "File", dataPart[tableIndex].file, (part + tableIndex) + "File", "checkDataPartFile(this.id, this.options[this.selectedIndex].innerHTML, " + tableIndex + ", '" + part + "');", "movies");
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertRow(name, l++, "URL", dataPart[tableIndex].url, (part + tableIndex) + "URL", 200, "checkDataPartURL(this.id, this.value, " + tableIndex + ", '" + part + "');");
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		insertRow(name, l++, "Tags", dataPart[tableIndex].tag, (part + tableIndex) + "Tag", 200, "checkDataPartTitle(this.id, this.value, " + tableIndex + ", 'tag', '" + part + "');");
	}
	
	if (dataPart[tableIndex].entry != null) {
		$((part + tableIndex) + "Formatted").innerHTML = "<div style='width: 100%;'>" + dataPart[tableIndex].entry + "</div>";
	}
	
	hideBalloon();	
}

function constructDataPartTable(part) {
	var name = part + "sTable";
	
	var dataPart = getDataPart(part);
	
	var l = dataPart.length;
	
	var row;
	var row1;
	var row2;
	
	var cell;
	var cell1;
	var cell21;
	var cell22;
	var cell23;
	var cell3;
	
	while ($(name).rows.length > 0) {
		$(name).deleteRow(0);
	}
	
	var shift = 0;
	
	for (var i = 0; i < l; i++) {
		if (i == 0 || dataPart[i].year != dataPart[i - 1].year) {
			row = $(name).insertRow(i + shift);
			
			cell = row.insertCell(0);
			
			cell.innerHTML = dataPart[i].year;
			
			cell.className = "year";

			shift++;
		}
		
		row = $(name).insertRow(i + shift);
		
		cell = row.insertCell(0);
		
		cell.className = "fullWidth";
		
		cell.innerHTML = "<table class='fullWidth' id='" + (part + i) + "Wrapper'></table>";
		
		row1 = $((part + i) + "Wrapper").insertRow(0);
		row2 = $((part + i) + "Wrapper").insertRow(1);
	
		cell1 = row1.insertCell(0);
		cell21 = row1.insertCell(1);
		cell22 = row1.insertCell(2);
		cell23 = row1.insertCell(3);
		cell3 = row2.insertCell(0);
	
		cell21.id = (part + i) + "Formatted";
		
		cell1.innerHTML = "[" + (i + 1) + "]";
		cell21.innerHTML = ""; 
		cell22.innerHTML = 
			"<table id='" + (part + i) + "' class='entry' style='display: none;'></table>" +
			
			"<div id='" + (part + i) + "Operations' class='operations' style='display: block;'>" +
				((i == 0 || dataPart[i].year != dataPart[i - 1].year) ?
					"<span class=\"toggleInactive\">[&uarr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveEntryUp(" + i + ", '" + part + "');\">[&uarr;]</span>"
				) +
				
				((i == l - 1 || dataPart[i].year != dataPart[i + 1].year) ?
					"<span class=\"toggleInactive\">[&darr;]</span>"
				:
					"<span class=\"toggle\" onclick=\"moveEntryDown(" + i + ", '" + part + "');\">[&darr;]</span>"
				) +
				
				"<span class=\"toggle\" onclick=\"removeEntry(" + i + ", '" + part + "');\">[&ndash;]</span>" + 
				
				"<span class=\"toggle\" onclick=\"insertEntryAfter(" + i + ", '" + part + "');\">[\\/]</span>" +
				
				"</div>";
		cell23.innerHTML = "<div id=\"" + (part + i) + "Toggle\" class=\"toggle\" onclick=\"toggleDataPartTable(" + i + ", '" + part + "');\">[&Omicron;]</div>";
		cell3.innerHTML = "";

		cell1.className = "indexCell";
		cell21.className = "presentCell";
		cell22.className = "operationCell";
		cell23.className = "toggleCell";
		
		cell3.colSpan = "4";
		
		populateDataPartTable(i, part);
	}
}

function removeAuthor(tableIndex, index, part, populate) {
	var dataPart = getDataPart(part);
	
	var l = dataPart[tableIndex].authors.length;
	
	for (var i = index; i < l - 1; i++) {
		dataPart[tableIndex].authors[i] = dataPart[tableIndex].authors[i + 1];
	}

	dataPart[tableIndex].authors.length--;
	
	generateEntry(tableIndex, part);
	
	if (populate) {
		populateDataPartTable(tableIndex, part);
	}
}

function moveAuthorUp(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var i = dataPart[tableIndex].authors[index - 1];
	dataPart[tableIndex].authors[index - 1] = dataPart[tableIndex].authors[index];
	dataPart[tableIndex].authors[index] = i;
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function moveAuthorDown(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var i = dataPart[tableIndex].authors[index + 1];
	dataPart[tableIndex].authors[index + 1] = dataPart[tableIndex].authors[index];
	dataPart[tableIndex].authors[index] = i;
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function insertAuthorAfter(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var l = dataPart[tableIndex].authors.length;
	
	for (var i = l; i > index + 1; i--) {
		dataPart[tableIndex].authors[i] = dataPart[tableIndex].authors[i - 1];
	}

	dataPart[tableIndex].authors[index + 1] = new Object();
	dataPart[tableIndex].authors[index + 1].name = "";
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function removeEditor(tableIndex, index, part, populate) {
	var dataPart = getDataPart(part);
	
	var l = dataPart[tableIndex].editors.length;
	
	for (var i = index; i < l - 1; i++) {
		dataPart[tableIndex].editors[i] = dataPart[tableIndex].editors[i + 1];
	}

	dataPart[tableIndex].editors.length--;
	
	generateEntry(tableIndex, part);
	
	if (populate) {
		populateDataPartTable(tableIndex, part);
	}
}

function moveEditorUp(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var i = dataPart[tableIndex].editors[index - 1];
	dataPart[tableIndex].editors[index - 1] = dataPart[tableIndex].editors[index];
	dataPart[tableIndex].editors[index] = i;
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function moveEditorDown(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var i = dataPart[tableIndex].editors[index + 1];
	dataPart[tableIndex].editors[index + 1] = dataPart[tableIndex].editors[index];
	dataPart[tableIndex].editors[index] = i;
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function insertEditorAfter(tableIndex, index, part) {
	var dataPart = getDataPart(part);
	
	var l = dataPart[tableIndex].editors.length;
	
	for (var i = l; i > index + 1; i--) {
		dataPart[tableIndex].editors[i] = dataPart[tableIndex].editors[i - 1];
	}

	dataPart[tableIndex].editors[index + 1] = new Object();
	dataPart[tableIndex].editors[index + 1].name = "";
	
	generateEntry(tableIndex, part);
	
	populateDataPartTable(tableIndex, part);
}

function removeEntry(tableIndex, part) {
	var proceed = confirm("Are you sure you want to remove this entry?");
		
	if (!proceed) {
		return;
	}
	
	var dataPart = getDataPart(part);
	
	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text == "") {	
					var l = dataPart.length;
					
					for (var i = tableIndex; i < l - 1; i++) {
						dataPart[i] = dataPart[i + 1];
					}
				
					dataPart.length--;
				
					constructDataPartTable(part);
					
					if (dataPart.length == 0) {
						toggleDataPart(part);
					}
				} else {
					alert (text);
				}
			}
		},
		"request=remove_entry&part=" + part + "&id=" + dataPart[tableIndex].id  
	);
}

function moveEntryUp(tableIndex, part) {
	var dataPart = getDataPart(part);
	
	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text == "") {					
					var i = dataPart[tableIndex - 1];
					dataPart[tableIndex - 1] = dataPart[tableIndex];
					dataPart[tableIndex] = i;
				
					constructDataPartTable(part);
				} else {
					alert (text);
				}
			}
		},
		"request=move_entry_up&part=" + part + "&id=" + dataPart[tableIndex].id  
	);
}

function moveEntryDown(tableIndex, part) {
	var dataPart = getDataPart(part);
	
	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text == "") {	
					var i = dataPart[tableIndex + 1];
					dataPart[tableIndex + 1] = dataPart[tableIndex];
					dataPart[tableIndex] = i;
				
					constructDataPartTable(part);
				} else {
					alert (text);
				}
			}
		},
		"request=move_entry_down&part=" + part + "&id=" + dataPart[tableIndex].id  
	);
}

function createNewEntry(id, year, part) {
	var entry = new Object();
	
	entry.id = id;
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
		entry.authors = new Array();
		entry.authors[0] = new Object();
		entry.authors[0].name = MAIN_AUTHOR;
	}
	
	if (part == CHAPTER_TYPE) {
		entry.editors = new Array();
		entry.editors[0] = new Object();
		entry.editors[0].name = MAIN_AUTHOR;
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE) {
				
		entry.title = NEW_TITLE;
	}
	
	if (part == JOURNAL_TYPE) {
		entry.journal = NEW_JOURNAL;
	}
	
	if (part == MAGAZINE_TYPE) {
		entry.magazine = NEW_MAGAZINE;
	}
	
	if (part == PROCEEDING_TYPE) {
		entry.conference = NEW_PROCEEDING;
	}
	
	if (part == PRESENTATION_TYPE) {
		entry.venue = NEW_PRESENTATION;
	}
	
	if (part == REPORT_TYPE) {
		entry.institution = NEW_REPORT;
	}
	
	if (part == CHAPTER_TYPE) {
		entry.book = NEW_CHAPTER;
	}
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == MULTIMEDIA_TYPE || 
			part == PRESENTATION_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		entry.year = year;
	}
	
	return entry;
}

function insertEntryAfter(tableIndex, part) {
	var dataPart = getDataPart(part);
	
	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text.indexOf("error") < 0) {
					var id = parseInt(text);
					var year = dataPart[tableIndex].year;
					
					var l = dataPart.length;
					
					for (var i = l; i > tableIndex + 1; i--) {
						dataPart[i] = dataPart[i - 1];
					}
					
					dataPart[tableIndex + 1] = createNewEntry(id, year, part);
				
					constructDataPartTable(part);
				} else {
					alert (text);
				}
			}
		},
		"request=insert_entry_after&part=" + part + "&id=" + dataPart[tableIndex].id  
	);
}

function changeEntryYear(id, year, part) {
	var dataPart = getDataPart(part);

	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text == "") {
					var l = dataPart.length;
					
					var fromPosition = -1;
					var toPosition = -1;
					var prevYear = 0;
					
					if (dataPart[0].year < year) {
						toPosition = 0;
					} else if (dataPart[l - 1].year > year) {
						toPosition = l;
					}
					
					for (var i = 0; i < l; i++) {
						if (dataPart[i].id == id) {
							fromPosition = i;
						} else if (toPosition == -1) {
							if (dataPart[i].year == year) {
								toPosition = i;
							} else if (dataPart[i].year < year && prevYear > year) {
								toPosition = i;
							}
						}
						
						prevYear = dataPart[i].year;
					}
					
					dataPart[fromPosition].year = year;
					
					if (fromPosition > -1 && toPosition > -1) {
						var temp = dataPart[fromPosition];

						if (fromPosition > toPosition) {
							for (var i = fromPosition; i > toPosition; i--) {
								dataPart[i] = dataPart[i - 1];
							}
						} else {
							toPosition--;
							
							for (var i = fromPosition; i < toPosition; i++) {
								dataPart[i] = dataPart[i + 1];
							}
						}
						
						dataPart[toPosition] = temp;
					}
					
					constructDataPartTable(part);
					
					if (toPosition < 0) {
						toPosition++;
					}
					
					setTimeout((function() { generateEntry(toPosition, part) }), 50);
				} else {
					alert (text);
				}
			}
		},
		"request=change_entry_year&part=" + part + "&id=" + id + "&year=" + year 
	);
}

function checkDataPartAuthor(id, text, tableIndex, index, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	try {
		text = validateAuthor(text);
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	var dataPart = getDataPart(part);
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	if (text != dataPart[tableIndex].authors[index].name) {
		dataPart[tableIndex].authors[index].name = text;
		
		generateEntry(tableIndex, part);
	}
}

function checkDataPartEditor(id, text, tableIndex, index, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	try {
		text = validateEditor(text);
		
		if (text == "") {
			/** TODO: Do we need to do something? */
		}
		
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	var dataPart = getDataPart(part);
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	if (text != dataPart[tableIndex].editors[index].name) {
		dataPart[tableIndex].editors[index].name = text;
		
		generateEntry(tableIndex, part);
	}
}

function checkDataPartTitle(id, text, tableIndex, field, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	try {
		if (	field == "title" || 
				field == "journal" || 
				field == "magazine" || 
				field == "conference" || 
				field == "venue" || 
				field == "institution" ||
				field == "book"	) {
					
			text = validateTitle(text, true);
		} else if (
				field == "place" || 
				field == "comment" ) {
					
			text = validateTitle(text, false);
		} else if (field == "tag") {
			text = validateTags(text, false);
		}
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	var dataPart = getDataPart(part);
	
	var valueChanged = false;
	
	if (field == "title") {
		if (text != dataPart[tableIndex].title) {
			dataPart[tableIndex].title = text;
			valueChanged = true;
		}
	} else if (field == "journal") {
		if (text != dataPart[tableIndex].journal) {
			dataPart[tableIndex].journal = text;
			valueChanged = true;
		}
	}  else if (field == "magazine") {
		if (text != dataPart[tableIndex].magazine) {
			dataPart[tableIndex].magazine = text;
			valueChanged = true;
		}
	}  else if (field == "conference") {
		if (text != dataPart[tableIndex].conference) {
			dataPart[tableIndex].conference = text;
			valueChanged = true;
		}
	} else if (field == "venue") {
		if (text != dataPart[tableIndex].venue) {
			dataPart[tableIndex].venue = text;
			valueChanged = true;
		}
	} else if (field == "institution") {
		if (text != dataPart[tableIndex].institution) {
			dataPart[tableIndex].institution = text;
			valueChanged = true;
		}
	} else if (field == "book") {
		if (text != dataPart[tableIndex].book) {
			dataPart[tableIndex].book = text;
			valueChanged = true;
		}
	} else if (field == "place") {
		if (text != (dataPart[tableIndex].place == null ? "" : dataPart[tableIndex].place)) {
			dataPart[tableIndex].place = text;
			valueChanged = true;
		}
	} else if (field == "comment") {
		if (text != (dataPart[tableIndex].comment == null ? "" : dataPart[tableIndex].comment)) {
			dataPart[tableIndex].comment = text;
			valueChanged = true;
		}
	} else if (field == "tag") {
		if (text != (dataPart[tableIndex].tag == null ? "" : dataPart[tableIndex].tag)) {
			dataPart[tableIndex].tag = text;
			valueChanged = true;
		}
	}
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	if (valueChanged) {		
		generateEntry(tableIndex, part);
	}
}

function checkDataPartNumber(id, text, tableIndex, field, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	try {
		if (field == "year") {
			text = validateNumber(text, 9999, true);
		} else if (field == "volume" || field == "issue" || field == "size") {
			text = validateNumber(text, 9999, false);
		} else if (field == "startPage" || field == "endPage") {
			text = validateNumber(text, 99999, false);
		} 
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	var dataPart = getDataPart(part);
	
	var valueChanged = false;
	
	if (field == "year") {
		if (dataPart[tableIndex].year != text) {
			//dataPart[tableIndex].year = text;
			valueChanged = true;
		}
	} else if (field == "volume") {
		if ((dataPart[tableIndex].volume == null ? "" : dataPart[tableIndex].volume) != text) {
			dataPart[tableIndex].volume = text;
			valueChanged = true;
		}
	} else if (field == "issue") {
		if ((dataPart[tableIndex].issue == null ? "" : dataPart[tableIndex].issue) != text) {
			dataPart[tableIndex].issue = text;
			valueChanged = true;
		}
	} else if (field == "size") {
		if ((dataPart[tableIndex].size == null ? "" : dataPart[tableIndex].size) != text) {
			dataPart[tableIndex].size = text;
			valueChanged = true;
		}
	} else if (field == "startPage") {
		if ((dataPart[tableIndex].startPage == null ? "" : dataPart[tableIndex].startPage) != text) {
			dataPart[tableIndex].startPage = text;
			valueChanged = true;
		}
	} else if (field == "endPage") {
		if ((dataPart[tableIndex].endPage == null ? "" : dataPart[tableIndex].endPage) != text) {
			dataPart[tableIndex].endPage = text;
			valueChanged = true;
		}
	}
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	if (valueChanged) {
		if (field == "year") {
			changeEntryYear(dataPart[tableIndex].id, text, part);
		} else {
			generateEntry(tableIndex, part);
		}
	}
}

function checkDataPartFile(id, text, tableIndex, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	var dataPart = getDataPart(part);
	
	if ((dataPart[tableIndex].file == null ? "" : dataPart[tableIndex].file) != text) {
		dataPart[tableIndex].file = text;
	
		generateEntry(tableIndex, part);
	}
}

function checkDataPartURL(id, text, tableIndex, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	try {
		text = validateURL(text);
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	var dataPart = getDataPart(part);
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	if (text != dataPart[tableIndex].url) {
		dataPart[tableIndex].url = text;
		
		generateEntry(tableIndex, part);
	}
}

function checkDataPartDate(id, text, tableIndex, field, part) {
	if (balloonIsShown() && id != balloonSourceId) {
		return;
	}
	
	text = trim(text);
	
	var dataPart = getDataPart(part);
	
	try {
		text = validateDate(text, false, dataPart[tableIndex].year == null ? "" : dataPart[tableIndex].year); 
	} catch (failed) {
		showBalloon(id, failed);
		
		setTimeout((function() { $(id).focus() }), 0);
		$(id).className = "textError";
		
		return;
	}
	
	$(id).value = text;
	$(id).className = "";
	
	hideBalloon();
	
	var valueChanged = false;
	
	if (field == "startDate") {
		if (text != dataPart[tableIndex].startDate) {
			dataPart[tableIndex].startDate = text;
			valueChanged = true;
		}
	} else if (field == "endDate") {
		if (text != dataPart[tableIndex].endDate) {
			dataPart[tableIndex].endDate = text;
			valueChanged = true;
		}
	} else if (field == "date") {
		if (text != dataPart[tableIndex].date) {
			dataPart[tableIndex].date = text;
			valueChanged = true;
		}
	}
	
	if (valueChanged) {
		generateEntry(tableIndex, part);
	}
}

function toggleDataPartTable(tableIndex, part) {
	var entry = $(part + tableIndex);
	var operations = $(part + tableIndex + "Operations");
	
	if (entry.style.display == "none") {
		operations.style.display = "none";
		entry.style.display = "block";
		
		$(part + tableIndex + "Toggle").innerHTML = "[&times;]";
	} else {
		operations.style.display = "block";
		entry.style.display = "none";
		
		$(part + tableIndex + "Toggle").innerHTML = "[&Omicron;]";
		
		var dataPart = getDataPart(part);
		
		if (dataPart[tableIndex].authors != null) {	
			for (var i = 0; i < dataPart[tableIndex].authors.length; i++) {
				if (trim(dataPart[tableIndex].authors[i].name) == "") {
					removeAuthor(tableIndex, i, part, false);
					i--;
				}
			}
		}
		
		if (dataPart[tableIndex].editors != null) {	
			for (var i = 0; i < dataPart[tableIndex].editors.length; i++) {
				if (trim(dataPart[tableIndex].editors[i].name) == "" && dataPart[tableIndex].editors.length > 1) {
					removeEditor(tableIndex, i, part, false);
					i--;
				}
			}
		}
		
		populateDataPartTable(tableIndex, part);
	}
}

function toggleDataPart(part) {
	var table = $(part + "sTable");
	
	if (table.style.display == "none") {
		var dataPart = getDataPart(part);
		
		var l = dataPart.length;
	
		var proceed = false;
		
		if (l == 0) {
			proceed = confirm("There are no " + part + " entries yet. Would you like to create one?");
			
			if (proceed) {
				var id = 0;
				
				var date = new Date();
				var year = date.getFullYear();
				
				new Ajax(
					URL,
					"POST",
					function(text, error) {
						if (error != null) {
							alert(error);
						} else {
							if (text.indexOf("error") < 0) {
								var receivedId = parseInt(text);

								dataPart[0] = createNewEntry(receivedId, year, part);
							
								constructDataPartTable(part);
								
								table.style.display = "block";
								
								$(part + "sToggler").innerHTML = "[&times;]";
								
							} else {
								alert (text);
							}
						}
					},
					"request=insert_entry_after&part=" + part + "&id=" + id  
				);
				
			}
		} else {
			table.style.display = "block";
			
			$(part + "sToggler").innerHTML = "[&times;]";
		}
	} else {
		table.style.display = "none";
		
		$(part + "sToggler").innerHTML = "[&Omicron;]";
	}
}

function generateEntry(index, part) {
	var dataPart = getDataPart(part);
	var currentDataPart = dataPart[index];
	
	var entry = null;
	
	if (part == JOURNAL_TYPE) {
		entry = new Journal({
			authors: currentDataPart.authors,
			title: currentDataPart.title,
			journal: currentDataPart.journal,
			year: currentDataPart.year,
			volume: currentDataPart.volume,
			issue: currentDataPart.issue,
			startPage: currentDataPart.startPage,
			endPage: currentDataPart.endPage,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == MAGAZINE_TYPE) {
		entry = new Magazine({
			authors: currentDataPart.authors,
			title: currentDataPart.title,
			magazine: currentDataPart.magazine,
			year: currentDataPart.year,
			volume: currentDataPart.volume,
			issue: currentDataPart.issue,
			startPage: currentDataPart.startPage,
			endPage: currentDataPart.endPage,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == PROCEEDING_TYPE) {
		entry = new Proceeding({
			authors: currentDataPart.authors,
			title: currentDataPart.title,
			conference: currentDataPart.conference,
			year: currentDataPart.year,
			startDate: currentDataPart.startDate,
			endDate: currentDataPart.endDate,
			place: currentDataPart.place,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == MULTIMEDIA_TYPE) {
		entry = new Multimedia({
			title: currentDataPart.title,
			year: currentDataPart.year,
			size: currentDataPart.size,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == PRESENTATION_TYPE) {
		entry = new Presentation({
			title: currentDataPart.title,
			venue: currentDataPart.venue,
			year: currentDataPart.year,
			date: currentDataPart.date,
			place: currentDataPart.place,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == REPORT_TYPE) {
		entry = new Report({
			authors: currentDataPart.authors,
			title: currentDataPart.title,
			institution: currentDataPart.institution,
			year: currentDataPart.year,
			place: currentDataPart.place,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	} else if (part == CHAPTER_TYPE) {
		entry = new Chapter({
			authors: currentDataPart.authors,
			editors: currentDataPart.editors,
			title: currentDataPart.title,
			book: currentDataPart.book,
			year: currentDataPart.year,
			comment: currentDataPart.comment,
			file: currentDataPart.file,
			url: currentDataPart.url,
			tag: currentDataPart.tag
		});
	}
	
	var entryText = entry.generateEntry();
	
	var authors = "";
	var editors = "";
	
	if (	part == JOURNAL_TYPE || 
			part == MAGAZINE_TYPE || 
			part == PROCEEDING_TYPE || 
			part == REPORT_TYPE ||
			part == CHAPTER_TYPE	) {
				
		for (var i = 0; i < currentDataPart.authors.length; i++) {
			if (i != 0) {
				authors += "|";
			}
			
			authors += currentDataPart.authors[i].name;
		}
	}
	
	if (part == CHAPTER_TYPE) {
				
		for (var i = 0; i < currentDataPart.editors.length; i++) {
			if (i != 0) {
				editors += "|";
			}
			
			editors += currentDataPart.editors[i].name;
		}
	}
	
	var query = "request=change_entry&part=" + part;

	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&authors=" + encodeURIComponent(authors);
	}
	
	if (part == CHAPTER_TYPE) {
		query += "&editors=" + encodeURIComponent(editors);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&id=" + encodeURIComponent(currentDataPart.id);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&title=" + encodeURIComponent(currentDataPart.title);
	}
	
	if (part == JOURNAL_TYPE) {
		query += "&journal=" + encodeURIComponent(currentDataPart.journal);
	}
	
	if (part == MAGAZINE_TYPE) {
		query += "&magazine=" + encodeURIComponent(currentDataPart.magazine);
	}
	
	if (part == PROCEEDING_TYPE) {
		query += "&conference=" + encodeURIComponent(currentDataPart.conference);
	}

	if (part == PRESENTATION_TYPE) {
		query += "&venue=" + encodeURIComponent(currentDataPart.venue);
	}
	
	if (part == REPORT_TYPE) {
		query += "&institution=" + encodeURIComponent(currentDataPart.institution);
	}
	
	if (part == CHAPTER_TYPE) {
		query += "&book=" + encodeURIComponent(currentDataPart.book);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&year=" + encodeURIComponent(currentDataPart.year);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		query += "&volume=" + encodeURIComponent(currentDataPart.volume == null ? "" : currentDataPart.volume);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		query += "&issue=" + encodeURIComponent(currentDataPart.issue == null ? "" : currentDataPart.issue);
	}
	
	if (part == MULTIMEDIA_TYPE) {
		query += "&size=" + encodeURIComponent(currentDataPart.size == null ? "" : currentDataPart.size);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		query += "&startPage=" + encodeURIComponent(currentDataPart.startPage == null ? "" : currentDataPart.startPage);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE) {
		query += "&endPage=" + encodeURIComponent(currentDataPart.endPage == null ? "" : currentDataPart.endPage);
	}
	
	if (part == PROCEEDING_TYPE) {
		query += "&startDate=" + encodeURIComponent(currentDataPart.startDate == null ? "" : currentDataPart.startDate);
	}
	
	if (part == PROCEEDING_TYPE) {
		query += "&endDate=" + encodeURIComponent(currentDataPart.endDate == null ? "" : currentDataPart.endDate);
	}
	
	if (part == PRESENTATION_TYPE) {
		query += "&date=" + encodeURIComponent(currentDataPart.date == null ? "" : currentDataPart.date);
	}

	if (part == PROCEEDING_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE) {
		query += "&place=" + encodeURIComponent(currentDataPart.place == null ? "" : currentDataPart.place);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&comment=" + encodeURIComponent(currentDataPart.comment == null ? "" : currentDataPart.comment);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&file=" + encodeURIComponent(currentDataPart.file == null ? "" : currentDataPart.file);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&url=" + encodeURIComponent(currentDataPart.url == null ? "" : currentDataPart.url);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&tag=" + encodeURIComponent(currentDataPart.tag == null ? "" : currentDataPart.tag);
	}
	
	if (part == JOURNAL_TYPE || part == MAGAZINE_TYPE || part == PROCEEDING_TYPE || part == MULTIMEDIA_TYPE || part == PRESENTATION_TYPE || part == REPORT_TYPE || part == CHAPTER_TYPE) {
		query += "&entry=" + encodeURIComponent(entryText == null ? "" : entryText);
	}
	
	new Ajax(
		URL,
		"POST",
		function(text, error) {
			if (error != null) {
				alert(error);
			} else {
				if (text == "") {
					currentDataPart.entry = entryText;
					$((part + index) + "Formatted").innerHTML = "<div style='width: 100%;'>" + entryText + "</div>";
				} else {
					alert (text);
				}
			}
		}, query
	);
}

function initialize() {
	new Ajax(
		URL + "?request=get_data",
		"GET",
		function(text, error) {
			if (error != null) {
				alert(error);
				return;
			}
			
			eval(text);
			
			constructDataPartTable(JOURNAL_TYPE);
			constructDataPartTable(MAGAZINE_TYPE);
			constructDataPartTable(CHAPTER_TYPE);
			constructDataPartTable(PROCEEDING_TYPE);
			constructDataPartTable(REPORT_TYPE);
			constructDataPartTable(PRESENTATION_TYPE);
			constructDataPartTable(MULTIMEDIA_TYPE);
		}
	);
}

initialize();