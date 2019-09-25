<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mechanical Turk HIT Results</title>
</head>
<body>
<style>
    body {
        font-family: Arial;
        margin: 10px 10px 10px 10px;
        padding: 0;
        color: white;
        text-align: center;
        background: #555652;
    }

    .container {
        color: #E8E9EB;
        border: #555652 1px solid;
        padding: 10px;
        margin: 10px;
    }
</style>
<div style="margin: 10px;">
    <img src="dashboardLogo.png" width="323" height="60">
</div>
<div class="container">
    <div style="float: left; width: 33%;" class="zoom">
        <a href="chartFile.php">
            <img src="graph1.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="chartWorker.php">
            <img src="graph2.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="radar.php">
            <img src="graph3.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="cake.php">
            <img src="graph4.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="topUser.php">
            <img src="graph5.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="scatter.php">
            <img src="graph6.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="randomChart.php">
            <img src="graph7.PNG" height="200" width="323"/>
        </a>
    </div>
    <div style="float: left; width: 33%;" class="zoom">
        <a href="sexChart.php">
            <img src="graph8.PNG" height="200" width="323"/>
        </a>
    </div>

    <style>
        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            transform: scale(1.02);
            opacity: 0.8;
        }
    </style>
</div>

</body>
</html>