function setMarker(name) {
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split(' ');
			marker.move(+arr[0], +arr[1]);
			document.getElementById("spinner").style.visibility = "hidden";
		}
	};	
	xhttp.open("GET", "php/getCoords.php?room=" + name, true);
	xhttp.send();
}

function search() {
	var a = document.getElementById("roomNum").value;
	document.getElementById("spinner").style.visibility = "visible";
	setMarker(a);
}

function getPath() {
	var from = document.getElementById("roomNumFrom").value;
	var to = document.getElementById("roomNumTo").value;
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
		}
	};	
	xhttp.open("GET", "php/findPath.php?start=" + from + "&end=" + to, true);
	xhttp.send();
}

function alert_coords(evt) {
    pt.x = evt.clientX;
    pt.y = evt.clientY;

    var cursorpt =  pt.matrixTransform(svg.getScreenCTM().inverse());
    console.log("(" + cursorpt.x + ", " + cursorpt.y + ")");
}

function getNearRoom(x, y, floor) {
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var data = this.responseText.split(' ');
			setMarker(data[2]);
		}
	};	
	xhttp.open("GET", "php/nearRoom.php?x=" + x + "&y=" + y + "&floor=" + floor, true);
	xhttp.send();
}