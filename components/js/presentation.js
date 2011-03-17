var Presentation = Base.extend({
	title: "",
	venue: "",
	year: 0,
	date: "",
	place: "",
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
		
		
		this.venue = this.venue.replace(/&/g, "&amp;");
		
		spacePos = this.venue.indexOf(" ");
		
		if (spacePos > -1) {
			this.venue = this.venue.substring(0, spacePos) + "&nbsp;" + this.venue.substring(spacePos + 1);
			this.venue = this.venue.replace(/\s-\s/g, "&mdash;");
		}
		
		entry += ", " + this.venue;
		
		if (this.date != null && this.date != "") {
			var startMonth = parseInt(this.date.split("/")[0]);
			var startDay = parseInt(this.date.split("/")[1]);
			
			if (!isNaN(startDay)) {
				entry += (", " + startDay + "&nbsp;" + parseMonth(startMonth));
			} else {
				entry += (", " + parseMonth(this.date));
			}
		}
	
		if (this.place != null && this.place != "") {
			this.place = this.place.replace(/&/g, "&amp;");
			
			spacePos = this.place.indexOf(" ");
		
			if (spacePos > -1) {
				this.place = this.place.substring(0, spacePos) + "&nbsp;" + this.place.substring(spacePos + 1);
			}
			
			spacePos = this.place.lastIndexOf(" ");
		
			if (spacePos > -1) {
				this.place = this.place.substring(0, spacePos) + "&nbsp;" + this.place.substring(spacePos + 1);
			}
			
			entry += (", " + this.place);
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
			
			entry += (" (" + this.comment + ")");
		}
		
		if (this.file != null && this.file != "") {
			var extension = "";	
		
			var extensionDelimiterIndex = this.file.lastIndexOf('.');
					
			if (extensionDelimiterIndex > 0 && this.file.length - extensionDelimiterIndex < 5) {
				extension = this.file.substring(extensionDelimiterIndex + 1).toUpperCase();
			}
			
			if (extension != "") {
				entry += ("&nbsp;<a class='ext_ref' href='" + PAPERS_DIR + "/" + this.file + "'>[" + extension + "]</a>");
			}
		}
		
		if (this.url != null && this.url != "") {
			entry += ("&nbsp;<a class='ext_ref' href='" + encodeURI(this.url) + "'>[Online]</a>");
		}
		
		return entry;
	}
});	