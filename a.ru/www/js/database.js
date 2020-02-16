function setMarker(name) {
	name = name.split(' ').join('_');
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split(' ');
			marker.move(+arr[0], +arr[1]-10);
			document.getElementById("spinner").style.visibility = "hidden";
		}
	};
	xhttp.open("GET", "php/getCoords.php?room=" + encodeURIComponent(name), true);
	xhttp.send();
}

function search() {
	var a = document.getElementById("roomNum").value;
	document.getElementById("spinner").style.visibility = "visible";
	setMarker(a);
}

function getPath() {
	document.getElementById("spinner").style.visibility = "visible";
	var from = document.getElementById("roomNumFrom").value.split(' ').join('_');
	var to = document.getElementById("roomNumTo").value.split(' ').join('_');
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			try {
				path.stroke({color: "#ffffff00"});
				path.clear();
			} catch (Exception) {}
			path = draw.polyline(this.responseText).fill('none');
			path.stroke({ color: '#f06', width: 4, linecap: 'round', linejoin: 'round' })
			document.getElementById("spinner").style.visibility = "hidden";
		}
	};	
	xhttp.open("GET", "php/findPath.php?start=" + encodeURIComponent(from) + "&end=" + encodeURIComponent(to), true);
	xhttp.send();
}

function getNearRoom(x, y, floor) {
	document.getElementById("spinner").style.visibility = "visible";
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var data = this.responseText.split(' ');
			setMarker(data[2]);
		}
	};	
	xhttp.open("GET", "php/nearRoom.php?x=" + encodeURIComponent(x) + "&y=" + encodeURIComponent(y) + "&floor=" + encodeURIComponent(floor), true);
	xhttp.send();
}

function cursorPoint(evt){
	pt.x = evt.clientX; pt.y = evt.clientY;
	return pt.matrixTransform(svg.getScreenCTM().inverse());
}