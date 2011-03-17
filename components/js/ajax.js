/*
 @include "Base.js";
*/

/*
 * Usage example:
 * new Ajax("somepage.txt", 
 * 	function(text){
 * 		alert(text);
 * 	}
 * );
 */

var request = false;

try {
	request = new XMLHttpRequest();
} catch (trymicrosoft) {
	try {
		request = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (othermicrosoft) {
		try {
			request = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (failed) {
			request = false;
		}  
	}
}

var AjaxBase = Base.extend({
	constructor: function(request, fun) {
		request.onreadystatechange = function() {		
			if (request.readyState == 4) {
				if (request.status == 200) {
					fun(request.responseText);
				} else if (request.status == 404) {
					fun("", "Requested URL is not found.");
				} else if (request.status == 403) {
					fun("", "Access denied.");
				} else {
					fun("", "Server error. Status is " + request.status);
				}
			}
		};
	}
});

var Ajax = AjaxBase.extend({
	constructor: function(url, type, fun, params) {
		if (type != "GET" && type != "POST") {
			alert("Invalid request method!");
			return;
		}
		
		request.open(type, url, true);

		this.base(request, fun);

		if (type == "GET") {
			request.send(null);	
		} else if (type == "POST") {			
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(params);
		}
	}
});