var INVALID_CHARS = "/\\[]{}!?@#$%*`;^&|<>";
var VALID_AUTHOR_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz,'- ";
var VALID_TITLE_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890,'- .~!@#$%&*()_+={}[]:;<>/";
var VALID_TAG_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890,- ";

/** a shortcut for getElementById */
function $(id) {
	return document.getElementById(id);
}

/** a shortcut for getElementsByName */
function $$(name) {
	return document.getElementsByName(name);
}

/** checks whether some variable is a function */
function isFunction(a) {
	return typeof a == 'function';
}

/** checks whether some variable is null */
function isNull(a) {
	return typeof a == 'object' && !a;
}

/** checks whether some variable is a number */
function isNumber(a) {
	return typeof a == 'number' && isFinite(a);
}

/** checks whether some variable is an object */
function isObject(a) {
	return (typeof a == 'object' && a) || isFunction(a);
}

/** converts a boolean to an integer */
function bool2int(a) {
	return a ? 1 : 0;
}

function uncache(url) {
	var d = new Date();
	
	var time = d.getTime();
	
	return (url + "&time=" + time);
} 

/** rounds the number to the specified precision */
function round(num, digits) {
	var divider = 1.0;
	
	for (var i = 0; i < digits; i++) {
		divider *= 10.0;
	}
	
	return Math.round(num * divider) / divider; 
}

/** trims the string from preceding or trailing spaces */
function trim(str) {
	str = str.replace(/^\s+/, '');
	for (var i = str.length - 1; i >= 0; i--) {
		if (/\S/.test(str.charAt(i))) {
			str = str.substring(0, i + 1);
			break;
		}
	}
	return str;
}

/** checks if the string starts with the given substring */
function startsWith(st, wi) {
	if (st == "") {
		return (wi == "");
	}

	return (st.substring(wi.length, 0) == wi);
}

/** validates the author */
function validateAuthor(value) {
	value = trim(value);
	
	value = value.replace(/\s+/g, " ");
	
	if (value == null || value == "") {
		throw "Author's name is empty";
	}

	var l = value.length;

	var commaCount = 0;
	
	for (var i = 0; i < l; i++) {
		if (VALID_AUTHOR_CHARS.indexOf(value.charAt(i), 0) == -1) {
			throw "Author's name contains invalid characters";
		} else if (value.charAt(i) == ',') {
			commaCount++;
		}
	}
	
	if (commaCount > 1) {
		throw "Multiple commas in author's name";
	} else if (commaCount < 1) {
		throw "No commas in author's name";
	} else if (value.charAt(0) == ',') {
		throw "Author's last name is empty";
	} else if (value.charAt(l - 1) == ',') {
		throw "Author's first name is empty";
	}
	
	return value;
}

/** validates the editor */
function validateEditor(value) {
	value = trim(value);
	
	value = value.replace(/\s+/g, " ");
	
	if (value == null || value == "") {
		throw "Editor's name is empty";
	}

	var l = value.length;

	var commaCount = 0;
	
	for (var i = 0; i < l; i++) {
		if (VALID_AUTHOR_CHARS.indexOf(value.charAt(i), 0) == -1) {
			throw "Editor's name contains invalid characters";
		} else if (value.charAt(i) == ',') {
			commaCount++;
		}
	}
	
	if (commaCount > 1) {
		throw "Multiple commas in editor's name";
	} else if (commaCount < 1) {
		throw "No commas in editor's name";
	} else if (value.charAt(0) == ',') {
		throw "Editor's last name is empty";
	} else if (value.charAt(l - 1) == ',') {
		throw "Editor's first name is empty";
	}
	
	return value;
}

/** validates the given title */
function validateTitle(value, notEmpty) {
	value = trim(value);
	
	value = value.replace(/\s+/g, " ");
	
	if (notEmpty) {
		if (value == null || value == "") {
			throw "Field is empty";
		}
	} else {
		if (value == null || value == "") {
			return value;
		}
	}

	var l = value.length;
	
	for (var i = 0; i < l; i++) {
		if (VALID_TITLE_CHARS.indexOf(value.charAt(i), 0) == -1) {
			throw "Field contains invalid characters";
		}
	}
	
	return value;
}

/** validates the given tags */
function validateTags(value) {
	value = trim(value);
	
	value = value.replace(/\s+/g, " ");
	
	if (value == null || value == "") {
		return value;
	}

	value = value.toLowerCase();
	
	var l = value.length;
	
	for (var i = 0; i < l; i++) {
		if (VALID_TAG_CHARS.indexOf(value.charAt(i), 0) == -1) {
			throw "Field should only contain comma-separated alpha-numeric tags";
		}
	}
	
	return value;
}

/** validates the given number */
function validateNumber(value, limit, notEmpty) {
	value = trim(value);
	
	value = value.replace(/\s+/g, " ");
	
	if (notEmpty) {
		if (value == null || value == "") {
			throw "Field is empty";
		}
	} else {
		if (value == null || value == "") {
			return value;
		}
	}
	
	var l = value.length;
	
	try {
		value = parseInt(value);
		
		if (!isNumber(value)) {
			throw "It is not a numeric value";
		} else if (value < 0) {
			throw "It is not a positive integer";
		} else if (value > limit) {
			throw "The number exceeds the valid limit";
		}
	} catch (failed) {
		throw "It is not a numeric value";
	}
	
	return value;
}

/** validates the given URL */
function validateURL(value, notEmpty) {
	value = trim(value);

	if (notEmpty) {
		if (value == null || value == "") {
			throw "Field is empty";
		}
	} else {
		if (value == null || value == "") {
			return value;
		}
	}
	
    var r = new RegExp();
    r.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/\+.=]+$");
    
    if (!r.test(value)) {
        throw "It is not a valid URL";
    }
    
    return value;
}

/** validates the given date */
function validateDate(value, notEmpty, year) {
	var newDate;
	
	if (year == "") {
		throw "You need to first specify the year";
	}
	
	value = trim(value);

	if (notEmpty) {
		if (value == null || value == "") {
			throw "Field is empty";
		}
	} else {
		if (value == null || value == "") {
			return value;
		}
	}
	
	value = value.toLowerCase();
	
	var monthOnly = false;
	
	if (
		value == "jan" || value == "feb" || value == "mar" || 
		value == "apr" || value == "may" || value == "jun" || 
		value == "jul" || value == "aug" || value == "sep" || 
		value == "oct" || value == "nov" || value == "dec") {
			
		value = value.charAt(0).toUpperCase() + value.substring(1);
		monthOnly = true;
	} else if (value.search(/^\d{1,2}[\/|\-|\.|_]\d{1,2}/g) != 0) {
		throw "Invalid date";
	}
	
	value = value.replace(/[\-|\.|_]/g, "/");
	
	newDate = value;
	
	if (!monthOnly) {
		if (newDate.charAt(0) == "0") {
			newDate = newDate.substring(1);
		}
		
		if (newDate.charAt(1) == "/") {
			if (newDate.charAt(2) == "0") {
				newDate = newDate.substring(0, 2) + newDate.substring(3);
			}
		} else {
			if (newDate.charAt(3) == "0") {
				newDate = newDate.substring(0, 3) + newDate.substring(4);
			}
		}		
		
		value += ("/" + year);
	
		var dt = new Date(Date.parse(value));
		
		var arrDateParts = value.split("/");
		
		if (dt.getMonth() != arrDateParts[0] - 1 ||
			dt.getDate() != arrDateParts[1] ||
			dt.getFullYear() != arrDateParts[2]) {
	
			throw "Invalid month and date range";
		}
	}
	
    return newDate;
}