function parseAuthors(authors) {
	var entry = "";
	
	var size = authors.length;
	
	var separatorPos;
	var currentAuthor;
	
	var lastName;
	var firstName;
	
	var firstNameParts;
	var firstNamePartsSize;
	var firstNamePartFirstLetterCode;
	
	var isMainAuthor;
	
	for (var i = 0; i < size; i++) {
		if (i != 0) {
			if (size != 2 || i != 1) {
				entry += ",";
			}
			
			entry += " ";
			
			if (i == size - 1) {
				entry += "and ";
			}
		}
		
		currentAuthor = authors[i].name;
		
		isMainAuthor = (currentAuthor == MAIN_AUTHOR);
		
		separatorPos = currentAuthor.indexOf(",");
		
		if (isMainAuthor) {
			entry += "<span class='bold'>"
		}
		
		if (separatorPos > -1) {
			firstName = currentAuthor.substring(separatorPos + 1);
			firstName = trim(firstName);
			
			lastName = currentAuthor.substring(0, separatorPos);
			lastName = trim(lastName);
			
			firstNameParts = firstName.split(" ");
			firstNamePartsSize = firstNameParts.length;
			
			if (firstNamePartsSize > 1) {
				for (var j = 0; j < firstNamePartsSize; j++) {
					firstNamePartFirstLetterCode = firstNameParts[j].charCodeAt(0);
					
					if (firstNamePartFirstLetterCode >= 65 && firstNamePartFirstLetterCode <= 90) {
						entry += firstNameParts[j].charAt(0) + ".&nbsp;";
					}
				}
			} else {
				entry += firstName.charAt(0) + ".&nbsp;";
			}
			
			entry += lastName;
		} else {
			entry += currentAuthor;
		}
		
		if (isMainAuthor) {
			entry += "</span>"
		}
	}
	
	return entry;
}

function parseMonth(month) {
	var str = "";
	
	if (month == 1 || month == "Jan") {
		str = "January";
	} else if (month == 2 || month == "Feb") {
		str = "February";
	} else if (month == 3 || month == "Mar") {
		str = "March";
	} else if (month == 4 || month == "Apr") {
		str = "April";
	} else if (month == 5 || month == "May") {
		str = "May";
	} else if (month == 6 || month == "Jun") {
		str = "June";
	} else if (month == 7 || month == "Jul") {
		str = "July";
	} else if (month == 8 || month == "Aug") {
		str = "August";
	} else if (month == 9 || month == "Sep") {
		str = "September";
	} else if (month == 10 || month == "Oct") {
		str = "October";
	} else if (month == 11 || month == "Nov") {
		str = "November";
	} else if (month == 12 || month == "Dec") {
		str = "December";
	}
	
	return str;
}