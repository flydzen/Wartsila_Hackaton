function setMarker(name) {
	name = name.split(' ').join('_');
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var arr = this.responseText.split(' ');
			setFloorByRoom(name, +arr[0], +arr[1]-10);
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
			var lvls = temp[0].split(",");
			var ways = temp[1].split("|");
			var xyStart = ways[0].split(' ')[0].split(',');
			var temp2 = ways[ways.length-1].split(' ');  // пути на последнем этаже
			var xyEnd = temp2[temp2.length-1].split(',');
			try {
				startCircle.fill("#ffffff00");
				endCircle.fill("#ffffff00");
				startCircle.clear();
				endCircle.clear();
			} catch (Exception) {}
			for (var i = 0; i < lvls.length; i++) {
				printPath(ways[i], lvls[i]);
			}
			startCircle = draw[lvls[0]].circle(30).move(+xyStart[0] - 15, +xyStart[1] - 15);
			endCircle = draw[lvls[lvls.length-1]].circle(30).move(+xyEnd[0] - 15, +xyEnd[1] - 15);	
		}
	};	
	xhttp.open("GET", "php/findPath.php?start=" + encodeURIComponent(from) + "&end=" + encodeURIComponent(to), true);
	xhttp.send();
}

function printPath(text, flr) {
	try {
		path[flr].stroke({color: "#ffffff00"});
		path[flr].clear();
	} catch (Exception) {}
	path[flr] = draw[flr].polyline(text).fill('none');
	path[flr].stroke({ color: '#f06', width: 4, linecap: 'round', linejoin: 'round' })
	document.getElementById("spinner").style.visibility = "hidden";
}

function getNearRoom(x, y) {
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

function getPeople() {
	name = document.getElementById('peopleName').value.split(' ')[0];
	lastName = document.getElementById('peopleName').value.split(' ')[1];
	document.getElementById("spinner").style.visibility = "visible";
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			setMarker(this.responseText);
		}
	};	
	xhttp.open("GET", "php/getRoomByPeople.php?name=" + encodeURIComponent(name) + "&lastName=" + encodeURIComponent(lastName), true);
	xhttp.send();
}

function cursorPoint(evt){
	pt[floor].x = evt.clientX; pt[floor].y = evt.clientY;
	return pt[floor].matrixTransform(svg[floor].getScreenCTM().inverse());
}

function setFloorByRoom(name, x, y) {
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			setFloor(this.responseText);
			marker[floor].move(x, y);
			if (floor % 2 == 0) {
				simple.style.display = "block"
				antresol.style.display = "none"
			} else {
				simple.style.display = "none"
				antresol.style.display = "block"
			}
		}
	};	
	xhttp.open("GET", "php/getFloor.php?name="+name, true);
	xhttp.send();
}

function setFloor(x) {
	for (var i = 0; i < svg.length; i++) {
		svg[i].style.display = "none";
		marker[i].style.display = "none";
		document.getElementById('btn' + i).style.border = "none";
	}
	svg[x].style.display = "block";
	marker[x].style.display = "block";
	document.getElementById('btn' + x).style.border = "solid #000 2px";
	floor = x;
	document.getElementById("spinner").style.visibility = "hidden";
}