<?php
session_start();
$pages = array('', 'chartFileWidget.php', 'chartWorkerWidget.php', 'radarWidget.php', 'cakeWidget.php', 'topUserWidget.php', 'scatterWidget.php', 'randomChartWidget.php', 'sexChartWidget.php');

if (empty($_SESSION['sel1']) && empty($_SESSION['sel2']) && empty($_SESSION['sel3'])) {
    $_SESSION['sel1'] = 1;
    $_SESSION['sel2'] = 2;
    $_SESSION['sel3'] = 3;
}

if (!empty($_POST['sel1'])) {
    $var1 = ($_SESSION['sel1'] + 1) % 9;
    if ($var1 == 0) {
        $_SESSION['sel1'] = 1;
    } else {
        $_SESSION['sel1'] = $var1;
    }
}
if (!empty($_POST['sel2'])) {
    $var2 = ($_SESSION['sel2'] + 1) % 9;
    if ($var2 == 0) {
        $_SESSION['sel2'] = 1;
    } else {
        $_SESSION['sel2'] = $var2;
    }
}
if (!empty($_POST['sel3'])) {
    $var3 = ($_SESSION['sel3'] + 1) % 9;
    if ($var3 == 0) {
        $_SESSION['sel3'] = 1;
    } else {
        $_SESSION['sel3'] = $var3;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<link
        rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <meta charset="UTF-8">
    <title>Mechanical Turk HIT Results</title>
</head>
<body style="background-color: #555652;">
<style>
    iframe {
        width: 33%;
        display: inline-block;
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
    }
</style>

<div style="margin-top: 5px;">
    <form method="post" id="form">
        <button type="submit" class="btn btn-secondary" id="button1" name="sel1" value="o" style="width: 33%;
        display: inline-block;">Next
        </button>

        <button type="submit" class="btn btn-secondary" id="button2" name="sel2" value="o" style="width: 33%;
        display: inline-block;">Next
        </button>

        <button type="submit" class="btn btn-secondary" id="button3" name="sel3" value="o" style="width: 33%;
        display: inline-block;">Next
        </button>

    </form>
</div>


<div>
    <iframe src="<?php if (!empty($_SESSION['sel1'])) {
        echo $pages[$_SESSION['sel1']];
    } ?>" name="iframe_a" scrolling="no" height="700" width="500" frameborder="0"></iframe>


    <iframe src="<?php if (!empty($_SESSION['sel2'])) {
        echo $pages[$_SESSION['sel2']];
    } ?>" name="iframe_a" scrolling="no" height="700" width="500" frameborder="0"></iframe>

    <iframe src="<?php if (!empty($_SESSION['sel3'])) {
        echo $pages[$_SESSION['sel3']];
    } ?>" name="iframe_a" scrolling="no" height="700" width="500" frameborder="0"></iframe>
</div>

<div style="text-align:center; margin-bottom: 10px;">
    <button style="font-size:16px;" onclick="window.location.href='/Chart'"
            class="btn btn-secondary">Dashboard <i
                class="fa fa-dashboard"></i></button>
</div>
</body>
</html>