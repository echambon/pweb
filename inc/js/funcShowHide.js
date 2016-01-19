function showHide(shID) {
	if (document.getElementById(shID)) {
	  if (document.getElementById(shID).style.display != 'block') {
		 document.getElementById(shID).style.display = 'block';
	  }
	  else {
		 document.getElementById(shID).style.display = 'none';
	  }
	}
}
