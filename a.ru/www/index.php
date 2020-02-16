<?php
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
    <svg id='drawing0' class="drawing"></svg>
    <svg id='drawing1' class="drawing"></svg>
    <svg id='drawing2' class="drawing"></svg>
    <svg id='drawing3' class="drawing"></svg>
    <script type="text/javascript">
    var svg = [];
    var marker = [];
    var draw = [];
    var path = [];
    var pt = [];
    var drawing = [];
    var floor = 0;
    var floors = [];
    var width = window.innerWidth;
    var height = window.innerHeight;
    $.ajax({
        url: 'img/floor1.svg',
        success: function(data) {
            var img = SVG('#drawing'+floor).size(width, height);
            img.svg(new XMLSerializer().serializeToString(data.documentElement));
            draw[floor] = SVG("#floor1"); 
            marker = draw[floor].image('img/marker.svg').size(25,25).move(-10000, -10000);            
            svg[floor] = document.getElementById('floor' + (floor + 1));
            drawing[floor] = document.getElementById('drawing' + floor);
            pt[floor] = svg[floor].createSVGPoint();
            document.getElementById('drawing' + floor).addEventListener('click', event => {
                var loc = cursorPoint(event);
                getNearRoom(Math.round(loc.x), Math.round(loc.y), 0);
            },false);
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
        }
    });
    </script>
    <div class="main">
        <div class="search">
            <form class="form">
            <label for="wayToRoom">Find place</label>
              <div class="container">
                <div class="row-fluid">
                  <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="search()" id="roomNum">
                    <? require('php/getNames.php') ?>
                  </select>
                </div>
              </div>
          </form>

        <form class="form formPath">
            <label for="wayToRoom">Way to room</label>
            <div class="container">
                <div class="row-fluid">
                  <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPath()" id="roomNumFrom">
                    <? require('php/getNames.php') ?>
                  </select>
                </div>
              </div>
            <div class="container">
                <div class="row-fluid">
                  <select class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="getPath()" id="roomNumTo">
                    <? require('php/getNames.php') ?>
                  </select>
                </div>
              </div>
          </form>
    </div>
        <div class="spinner-border text-primary" id="spinner" role="status">
            <span class="sr-only">Loading...</span>
        </div>

        <div class="floatingButtons">
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(3)">4</button> </div>
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(2)">3</button> </div>
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(1)">2</button> </div>
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn" onClick="setFloor(0)">1</button> </div>
        </div>
    </div>
    </body>
</html>
<script>
  var size = [document.documentElement.clientWidth,document.documentElement.clientHeight];
  window.onresize = function(){
      document.body.style.zoom = document.documentElement.clientWidth / size[0];
  }
  
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
