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
        margin: 50px;
    }
</style>
<h1 style="margin: 50px; color: black;">Dashboard: </h1>
<div class="container">
    <div style="float: left; width: 33%;">
        <a href="chartFile.php">
            <img src="graph1.PNG" height="250" width="388"/>
        </a>
    </div>
    <div style="float: left; width: 33%;">
        <a href="chartWorker.php">
            <img src="graph2.PNG" height="250" width="388"/>
        </a>
    </div>
    <div style="float: left; width: 33%;">
        <a href="radar.php">
            <img src="graph3.PNG" height="250" width="388"/>
        </a>
    </div>
    <div class="clearer"></div>
    <div style="float: left; width: 33%;">
        <a href="cake.php">
            <img src="graph4.PNG" height="250" width="388"/>
        </a>
    </div>
    <div style="float: left; width: 33%;">
        <a href="topUser.php">
            <img src="graph5.PNG" height="250" width="388"/>
        </a>
    </div>
    <div style="float: left; width: 33%;">
        <a href="scatter.php">
            <img src="graph6.PNG" height="250" width="388"/>
        </a>
    </div>
    <div style="float: left; width: 33%;">
        <a href="randomChart.php">
            <img src="graph7.PNG" height="250" width="388"/>
        </a>
    </div>
</div>

</body>
</html>