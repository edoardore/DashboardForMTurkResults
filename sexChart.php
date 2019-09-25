<?php
/* Database connection settings */
$host = 'localhost';
$user = 'utente';
$pass = 'pass123';
$db = 'dbmysql';
$mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);
session_start();
$data1 = '';
if (!empty($_POST['db'])) {
    $db = $_POST['db'];
    if ($db == 'Image') {
        $_SESSION['db'] = 'Image';
        $sql = "SELECT QUALITY FROM `immquality`";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
        }
        $data1 = trim($data1, ",");
    } else
        if ($db == 'Video') {
            $_SESSION['db'] = 'Video';
            $sql = "SELECT QUALITY FROM `vidquality`";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $data1 = $data1 . '"' . $row['QUALITY'] . '",';
            }
            $data1 = trim($data1, ",");

        }
}
if (!empty($_POST['sex']) && !empty($_SESSION['db'])) {
    if ($_SESSION['db'] == 'Image') {
        $sex = $_POST['sex'];
        $sql = "SELECT QUALITY FROM `immquality` WHERE SEX= '$sex'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
        }
        $data1 = trim($data1, ",");

    } else if ($_SESSION['db'] == 'Video') {
        $sex = $_POST['sex'];
        $sql = "SELECT QUALITY FROM `vidquality` WHERE SEX= '$sex'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
        }
        $data1 = trim($data1, ",");

    }
} else {
    $sex = ' ';
    $data1 = 0;
}

?>

<!DOCTYPE html>
<html>
<link
        rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <title>Mechanical Turk HIT Results</title>

    <style type="text/css">
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
            background: #222;
            border: #555652 1px solid;
            padding: 10px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>MALE VS FEMALE EVALUATIONS</h1>
</div>
<form method="post" id="form">
    <div class="btn-group btn-group-toggle container" data-toggle="buttons">
        <label class="btn btn-secondary">
            <input type="radio" name="db" id="option1" autocomplete="off"
                   onclick="document.getElementById('form').submit();" value="Video"> Video
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="db" id="option2" autocomplete="off"
                   onclick="document.getElementById('form').submit();" value="Image"> Image
        </label>
    </div>
</form>
<form method="post" id="form2">
    <div class="btn-group btn-group-toggle container" data-toggle="buttons">
        <label class="btn btn-secondary">
            <input type="radio" name="sex" id="option3" autocomplete="off"
                   onclick="document.getElementById('form2').submit();" value="M"> Male
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="sex" id="option4" autocomplete="off"
                   onclick="document.getElementById('form2').submit();" value="F"> Female
        </label>
    </div>
</form>

<div class="container">
    <canvas id="chart"
            style="width: 70%; height: 40vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
    <script>
        var ctx = document.getElementById("chart").getContext('2d');
        var sum = 0;
        var data1 = [<?php echo $data1; ?>];
        var count = [];
        for (var i = 0; i < 5; i++) {
            count[i] = 0;
        }
        for (var j = 0; j < data1.length; j++) {
            if (data1[j] < 20 && data1[j] >= 0) {
                count[0] += 1;
            }
            if (data1[j] < 40 && data1[j] >= 20) {
                count[1] += 1;
            }
            if (data1[j] < 60 && data1[j] >= 40) {
                count[2] += 1;
            }
            if (data1[j] < 80 && data1[j] >= 60) {
                count[3] += 1;
            }
            if (data1[j] <= 100 && data1[j] >= 80) {
                count[4] += 1;
            }
        }
        for (var k = 0; k < 5; k++) {
            count[k] = Math.round(count[k] * 100 / data1.length);
        }
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Bad', 'Poor', 'Fair', 'Good', 'Excellent'],
                datasets:
                    [{
                        data: count,
                        backgroundColor: ['rgb(255,34,0, 0.2)', 'rgba(255,117,0,0.2)', 'rgba(255,206,0,0.2)', 'rgba(156,255,0,0.2)', 'rgba(0,255,13,0.2)'],
                        borderColor: ['rgb(255,34,0)', 'rgba(255,117,0)', 'rgba(255,206,0)', 'rgba(156,255,0)', 'rgba(0,255,13)'],
                        borderWidth: 3
                    }]
            },
            options: {
                scales: {scales: {yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                tooltips: {mode: 'index'},
                legend: {display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}},
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Gender choosed: ' + '<?php echo $sex;?>',
                    fontColor: 'rgba(255,249,255,0.5)',
                    fontSize: 16,
                }
            }

        });
    </script>
    <div class="container">
        <style>
            a {
                text-decoration: none;
                display: inline-block;
                padding: 8px 16px;
            }

            a:hover {
                background-color: white;
                color: black;
            }

            .previous {
                background-color: white;
                color: black;
                float: left;
            }

            .next {
                background-color: white;
                color: black;
                float: right;
            }

            .round {
                border-radius: 50%;
            }
        </style>
        <a href="randomChart.php" class="previous round">&#8249;</a>

        <button style="font-size:16px" onclick="window.location.href='/Chart'" class="btn btn-secondary">Dashboard <i
                    class="fa fa-dashboard"></i>
        </button>

        <a href="chartFile.php" class="next round">&#8250;</a>

    </div>
</div>
</body>
</html>