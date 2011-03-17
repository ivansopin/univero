var Multimedia = Base.extend({
	title: "",
	year: 0,
	size: 0,
	comment: "",
	file: "",
	url: "",
	
	generateEntry: function() {
		var entry = "";		
		
		this.title = this.title.replace(/&/g, "&amp;");
		
		var spacePos = this.title.indexOf(" ");
		
		if (spacePos > -1) {
			this.title = this.title.substring(0, spacePos) + "&nbsp;" + this.title.substring(spacePos + 1);
			this.title = this.title.replace(/\s-\s/g, "&mdash;");
		}
		
		entry += "<span class='bold'>" + this.title + "</span>"
		
		entry += "&nbsp;(" + this.year + ")";
		
		if (this.file != null && this.file != "") {
			var extension = "";	
		
			var extensionDelimiterIndex = this.file.lastIndexOf('.');
					
			if (extensionDelimiterIndex > 0 && this.file.length - extensionDelimiterIndex < 5) {
				extension = this.file.substring(extensionDelimiterIndex + 1).toUpperCase();
			}
			
			if (extension != "") {
				entry += ("&nbsp;<a class='ext_ref' href='" + MULTIMEDIA_DIR + "/" + this.file + "'>[" + extension + "]</a>");
			}
		}
		
		if (isNumber(this.size) && this.size != 0) {
			entry += "&nbsp;(~" + this.size + "&nbsp;MB)";
		}	
		
		if (this.url != null && this.url != "") {
			entry += ("&nbsp;<a class='ext_ref' href='" + encodeURI(this.url) + "'>[Online]</a>");
		}
		
		if (this.comment != null && this.comment != "") {
			this.comment = this.comment.replace(/&/g, "&amp;");
			
			spacePos = this.comment.indexOf(" ");
		
			if (spacePos > -1) {
				this.comment = this.comment.substring(0, spacePos) + "&nbsp;" + this.comment.substring(spacePos + 1);
			}
			
			spacePos = this.comment.lastIndexOf(" ");
		
			if (spacePos > -1) {
				this.comment = this.comment.substring(0, spacePos) + "&nbsp;" + this.comment.substring(spacePos + 1);
			}
			
			if (this.comment.charAt(this.comment.length - 1) != ".") {
				this.comment += ".";
			}
			
			entry += ("<br />" + this.comment);
		}
		
		return entry;
	}
});	