var Proceeding = Base.extend({
	authors: null,
	title: "",
	conference: "",
	year: 0,
	startDate: "",
	endDate: "",
	place: "",
	comment: "",
	file: "",
	url: "",
	
	generateEntry: function() {
		var entry = "";
		
		entry += parseAuthors(this.authors);
		
		entry += "&nbsp;(" + this.year + ")";
		
		
		this.title = this.title.replace(/&/g, "&amp;");
		
		var spacePos = this.title.indexOf(" ");
		
		if (spacePos > -1) {
			this.title = this.title.substring(0, spacePos) + "&nbsp;" + this.title.substring(spacePos + 1);
			this.title = this.title.replace(/\s-\s/g, "&mdash;");
		}
		
		entry += " &ldquo;<span class='italic'>" + this.title + ",</span>&rdquo;"
		
		
		this.conference = this.conference.replace(/&/g, "&amp;");
		
		spacePos = this.conference.indexOf(" ");
		
		if (spacePos > -1) {
			this.conference = this.conference.substring(0, spacePos) + "&nbsp;" + this.conference.substring(spacePos + 1);
			this.conference = this.conference.replace(/\s-\s/g, "&mdash;");
		}
		
		entry += " " + this.conference;
		
		if (this.startDate != null && this.startDate != "") {
			var startMonth = parseInt(this.startDate.split("/")[0]);
			var startDay = parseInt(this.startDate.split("/")[1]);
			
			if (this.endDate != null && this.endDate != "") {
				var endMonth = parseInt(this.endDate.split("/")[0]);
				var endDay = parseInt(this.endDate.split("/")[1]);
				
				if (startMonth < endMonth) {
					entry += (", " + startDay + "&nbsp;" + parseMonth(startMonth) + "&nbsp;&ndash; " + endDay + "&nbsp;" + parseMonth(endMonth));	
				} else if (startMonth == endMonth) {
					if (startDay < endDay) {
						entry += (", " + "<span class='nobreak'>" + startDay + "&ndash;" + endDay + "</span>&nbsp;" + parseMonth(startMonth));
					} else if (startDay == endDay) {
						entry += (", " + startDay + "&nbsp;" + parseMonth(startMonth));		
					}
				}
			} else {
				entry += (", " + startDay + "&nbsp;" + parseMonth(startMonth));
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