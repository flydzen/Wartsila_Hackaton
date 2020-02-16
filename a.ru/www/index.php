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
    <svg id='drawing'></svg>
    
    <script type="text/javascript">
    var svg;
    var marker;
    var draw;
    var path;
    var pt;
    var drawing;
    $.ajax({
        url: 'img/floor1.svg',
        success: function(data) {
            var width = window.innerWidth;
            var height = window.innerHeight;
            var img = SVG('#drawing').size(width, height);
            img.svg(new XMLSerializer().serializeToString(data.documentElement));
            draw = SVG("#floor1"); 
            marker = draw.image('img/marker.svg').size(25,25).move(-10000, -10000);            
            svg = document.getElementById('floor1');
            drawing = document.getElementById('drawing');
            pt = svg.createSVGPoint();
            document.getElementById('drawing').addEventListener('click', event => {
                var loc = cursorPoint(event);
                getNearRoom(Math.round(loc.x), Math.round(loc.y), 0);
            },false);
            var size = [document.documentElement.clientWidth,document.documentElement.clientHeight];
            window.onresize = function(){
                document.body.style.zoom = document.documentElement.clientWidth / size[0];
            }
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
    </script>
    <div class="main">
        <div class="search">
            <form class="form">
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
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn">3</button> </div>
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn">2</button> </div>
            <div><button type="button" class="btn btn-success btn-circle btn-md floorbtn">1</button> </div>
        </div>
    </div>
    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
