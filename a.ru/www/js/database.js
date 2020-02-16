function setMarker(name) {
	name = name.split(' ').join('_');
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split(' ');
			marker[floor].move(+arr[0], +arr[1]-10);
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
			var temp = this.responseText.split(",@");
			alert(temp);
			var lvls = temp[0].split(",");
			var ways = temp[1].split("|");
			for (var i = 0; i < lvls.length; i++) {
				printPath(ways[i], lvls[i]);
			}
		}
	};	
	xhttp.open("GET", "php/findPath.php?start=" + encodeURIComponent(from) + "&end=" + encodeURIComponent(to), true);
	xhttp.send();
}

function printPath(text, flr) {
	alert(text + " " + flr);
	try {
		path[flr].stroke({color: "#ffffff00"});
		path[flr].clear();
	} catch (Exception) {}
	path[flr] = draw[flr].polyline(text).fill('none');
	path[flr].stroke({ color: '#f06', width: 4, linecap: 'round', linejoin: 'round' })
	document.getElementById("spinner").style.visibility = "hidden";
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

function getPeoples(name, lastName) {
	document.getElementById("spinner").style.visibility = "visible";
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var data = this.responseText.split(' ');
			setMarker(data[2]);
		}
	};	
	xhttp.open("GET", "php/getRoomByPeople.php?name=" + encodeURIComponent(name) + "&lastName=" + encodeURIComponent(lastName), true);
	xhttp.send();
}

function cursorPoint(evt){
	pt[floor].x = evt.clientX; pt[floor].y = evt.clientY;
	return pt[floor].matrixTransform(svg[floor].getScreenCTM().inverse());
}

function setFloor(x) {
	for (var i = 0; i < svg.length; i++) {
		svg[i].style.display = "none";
		marker[i].style.display = "none";
	}
	svg[x].style.display = "block";
	marker[x].style.display = "block";
	floor = x;
}