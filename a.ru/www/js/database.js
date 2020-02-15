function setMarker(name) {
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split(' ');
			marker.move(+arr[0], +arr[1]);
		}
	};
	xhttp.open("GET", "php/getCoords.php?room=" + name, true);
	xhttp.send();
}