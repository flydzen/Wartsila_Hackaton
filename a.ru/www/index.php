<?php
    error_reporting(E_ERROR | E_PARSE);
    header('Content-type: text/html; charset=utf-8');
    $mysqli = new mysqli("localhost", "root", "", "nav");
?>

<!doctype html>
<html lang="en">
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/database.js"></script>
    <script type="text/javascript" src="js/svg.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <title>Oblepiha</title>
  </head>
  <body>
    <svg id="drawing"></svg>
    <script type="text/javascript">
    function readFile(i) {
      $.ajax({
          url: 'img/floor' + (i+1) + '.svg',
          success: function(data) {
              img.svg(new XMLSerializer().serializeToString(data.documentElement));
              draw[i] = SVG("#floor"+(i+1)); 
              svg[i] = document.getElementById('floor' + (i + 1));
              pt[i] = svg[i].createSVGPoint();
              if (i != 0) {
                  svg[i].style.display = "none";
              } else {
                document.getElementById('drawing').addEventListener('click', event => {
                    var loc = cursorPoint(event);
                    getNearRoom(Math.round(loc.x), Math.round(loc.y));
                },false);
              }
              marker[i] = draw[i].image('img/marker.svg').size(25,25).move(-10000, -10000);
              function addOnWheel(elem, handler) {
                if (elem.addEventListener) {
                  if ('onwheel' in document) {
                    elem.addEventListener("wheel", handler);
                  } else if ('onmousewheel' in document) {
                    elem.addEventListener("mousewheel", handler);
                  } else {
                    elem.addEventListener("MozMousePixelScroll", handler);
                  }
                }
              }
              var scale = 1;
              addOnWheel(drawing, function(e) {
                  var delta = e.deltaY || e.detail || e.wheelDelta;
                  if (delta < 0) scale += 0.05;
                  else scale -= 0.05;
                  drawing.style.transform = drawing.style.WebkitTransform = drawing.style.MsTransform = 'scale(' + scale + ')';
                  e.preventDefault();
              });
          }
      });
    }
    var startCircle;
    var endCircle;
    var svg = [];
    var marker = [];
    var draw = [];
    var path = [];
    var pt = [];
    var floor = 0;
    var width = window.innerWidth;
    var height = window.innerHeight;
    var img = SVG('#drawing').size(width, height);
    var drawing = document.getElementById('drawing');
    var t = [];
    for (var i = 0; i < 4; i++) {
      readFile(i);
    }
    </script>
    <div class="room">
      <label id="numberRoom"></label>
        <svg id="showRoom" style="transform: scale(2.5);">
      </svg>
    </div>
    <div class="main">
      <div class="search">
        <form class="form">
          <label for="wayToRoom">Find place</label>
          <div class="container">
            <div class="row-fluid">
              <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="search()" id="roomNum">
                <? include('php/getNames.php') ?>
              </select>
            </div>
            <button type="button" class="btn btn-success container" onclick="addEvent()">Добавить в список встреч</button>
          </div>
        </form>
        <form class="form formPath">
          <label for="wayToRoom">Way to room</label>
          <div class="container">
            <div class="row-fluid">
              <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPath()" id="roomNumFrom">
                <? include('php/getNames.php') ?>
              </select>
            </div>
          </div>
          <div class="container">
            <div class="row-fluid">
              <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPath()" id="roomNumTo">
                <? include('php/getNames.php') ?>
              </select>
            </div>
          </div>            <div class="container">
            <div class="row-fluid">
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                  <input type="radio" name="typeMove" id="Any" autocomplete="off" checked> Any
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="typeMove" id="Elevator" autocomplete="off"> Elevators
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="typeMove" id="Stairs" autocomplete="off"> Stairs  
                </label>
              </div>
            </div>
          </div>
        </form>
        <form class="form">
          <label for="wayToRoom">Search people</label>
            <div class="container">
              <div class="row-fluid">
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPeople()" id="peopleName">
                  <? include('php/getPeoples.php') ?>
                </select>
              </div>
            </div>
        </form>
        <form class="form">
          <div class='countainer'>
            <div class="list-group">
              <div class="list-group-item list-group-item-action active">
                Список встреч
              </div>
              <div id="events">
                <? include("php/printEvents.php") ?>
              </div>
            </div><button type="button" class="btn btn-danger" >Удалить встречу</button>
          </div>
        </form>
      </div>
      <div class="spinner-border text-primary" id="spinner" role="status">
          <span class="sr-only">Loading...</span>
      </div>
      <div class="floatingButtons">
          <div><button id="btn3" type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(3)">4</button> </div>
          <div><button id="btn2" type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(2)">3</button> </div>
          <div><button id="btn1" type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(1)">2</button> </div>
          <div><button id="btn0" type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(0)">1</button> </div>
      </div>
    </div>
    </body>
</html>
<script>
  document.getElementById('btn0').style.border = "solid #000 2px";
  var size = [document.documentElement.clientWidth,document.documentElement.clientHeight];
  window.onresize = function(){
      document.body.style.zoom = document.documentElement.clientWidth / size[0];
  }
  var room = SVG("#showRoom");
  var simple;
  var antresol;
  $.ajax({
    url: 'img/106.svg',
    success: function(data) {
      room.svg(new XMLSerializer().serializeToString(data.documentElement));
      simple = document.getElementById('rooma');
      simple.style.display = "none";
    }
  });
  $.ajax({
    url: 'img/106_antresol.svg',
    success: function(data) {
      room.svg(new XMLSerializer().serializeToString(data.documentElement));
      antresol = document.getElementById('roomb');
      antresol.style.display = "none";
    }
  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
