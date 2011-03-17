var balloonSourceId = "";

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
		
	return [curleft, curtop];
}

/** converts a style-based value to a math value */
function style2math(val) {
	if (!val) {
		return;
	}
	
	val = val.replace("px", "");
	
	if (isNaN(val)) {
		return 0;
	}
	
	return parseInt(val);
}

/** returns the real height of the specified object */
function getHeight(name) {
	var element = $(name); 
	
	if (element == null) {
		return;
	}
	
	var currentStyle;
	
	if (element.currentStyle) {
		currentStyle = element.currentStyle;
	} else if (window.getComputedStyle) {
		currentStyle = document.defaultView.getComputedStyle(element, null);
	} else {
		currentStyle = element.style;
	}
	
	return (
		element.offsetHeight -
		style2math(currentStyle.marginTop) -
		style2math(currentStyle.marginBottom) -
		style2math(currentStyle.borderTopWidth) -
		style2math(currentStyle.borderBottomWidth));			
}

function getWidth(name) {
	var element = $(name); 
	
	if (element == null) {
		return;
	}
	
	var currentStyle;
	
	if (element.currentStyle) {
		currentStyle = element.currentStyle;
	} else if (window.getComputedStyle) {
		currentStyle = document.defaultView.getComputedStyle(element, null);
	} else {
		currentStyle = element.style;
	}
	
	return (
		element.offsetWidth -
		style2math(currentStyle.marginLeft) -
		style2math(currentStyle.marginRight) -
		style2math(currentStyle.borderLeftWidth) -
		style2math(currentStyle.borderRightWidth));
}

function showBalloon(id, text) {
	balloonSourceId = id;
	
	var pos = findPos($(id));
	
	var balloon = $("balloon");
	
	balloon.innerHTML = text;
	
	balloon.style.display = "block";
	
	balloon.style.left = (pos[0] - getWidth("balloon") - 5) + "px";
	balloon.style.top = (pos[1]) + "px";
}

function hideBalloon() {
	var balloon = $("balloon");
	balloon.style.display = "none";
}

function balloonIsShown() {
	var balloon = $("balloon");
	return balloon.style.display == "block";
}