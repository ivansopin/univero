var Magazine = Base.extend({
	authors: null,
	title: "",
	magazine: "",
	year: 0,
	volume: 0,
	issue: 0,
	startPage: 0,
	endPage: 0,
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
		
		
		this.magazine = this.magazine.replace(/&/g, "&amp;");
		
		spacePos = this.magazine.indexOf(" ");
		
		if (spacePos > -1) {
			this.magazine = this.magazine.substring(0, spacePos) + "&nbsp;" + this.magazine.substring(spacePos + 1);
		}
		
		entry += " " + this.magazine;
		
		
		if (isNumber(this.volume) && this.volume != 0) {
			entry += ", Vol.&nbsp;" + this.volume;
			
			if (isNumber(this.issue) && this.issue != 0) {
				this.issue += "";
				
				var dashPos = this.issue.indexOf('-');
				
				if (dashPos > -1) {
					this.issue = "<span class='nobreak'>" + this.issue.substring(0, dashPos) + "&ndash;" + this.issue.substring(dashPos + 1) + "</span>";
				}
				
				entry += "(" + this.issue + ")";
			}
		}	
		
		if (isNumber(this.startPage) && this.startPage != 0) {
			entry += ", p"
			
			if (isNumber(this.endPage) && this.endPage != 0 && this.endPage > this.startPage) {
				if ((this.startPage + "").length == (this.endPage + "").length) {
					
					var l = (this.startPage + "").length;
					var num1 = this.startPage + "";
					var num2 = this.endPage + "";
					
					var cut = 0;
					
					for (var i = 0; i < l; i++) {
						if (num1.charAt(i) == num2.charAt(i)) {
							cut = i;	
						} else {
							break;
						}
					}
					
					entry += "<span class='nobreak'>" + "p.&nbsp;" + this.startPage + "&ndash;" + num2.substring(i) + "</span>";
					
				} else {
					entry += "<span class='nobreak'>" + "p.&nbsp;" + this.startPage + "&ndash;" + this.endPage + "</span>";
				}
			} else {
				entry += ".&nbsp;" + this.startPage;
			}
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