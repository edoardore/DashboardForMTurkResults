<?php
/* Database connection settings */
$host = 'localhost';
$user = 'utente';
$pass = 'pass123';
$db = 'dbmysql';
$mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);
session_start();
$result1 = '';
if (!empty($_POST['db'])) {
    $db = $_POST['db'];
    if ($db == 'Image') {
        $query1 = "SELECT DISTINCT WORKER_ID FROM `immquality`";
        $result1 = mysqli_query($mysqli, $query1);
        $_SESSION['db'] = 'Image';
    } else
        if ($db == 'Video') {
            $query2 = "SELECT DISTINCT WORKER_ID FROM `vidquality`";
            $result1 = mysqli_query($mysqli, $query2);
            $_SESSION['db'] = 'Video';
        }
}
$data1 = '';
$data2 = '';
if (!empty($_POST['worker_id'])) {
    if ($_SESSION['db'] == 'Image') {
        $worker_id = $_POST['worker_id'];
        $sql = "SELECT QUALITY, IMAGE_FILE FROM `immquality` WHERE WORKER_ID= '$worker_id'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
            $data2 = $data2 . '"' . $row['IMAGE_FILE'] . '",';

        }
        $data1 = trim($data1, ",");
        $data2 = trim($data2, ",");

    } else if ($_SESSION['db'] == 'Video') {
        $worker_id = $_POST['worker_id'];
        $sql = "SELECT QUALITY, VIDEO_FILE FROM `vidquality` WHERE WORKER_ID= '$worker_id'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
            $data2 = $data2 . '"' . $row['VIDEO_FILE'] . '",';

        }
        $data1 = trim($data1, ",");
        $data2 = trim($data2, ",");

    }
} else {
    $data1 = 0;
    $data2 = 0;
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
    <h1>EVALUATION HISTORY OF SINGLE WORKER</h1>
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
<form method="post">
    <div class="container">
        <select class="custom-select" name="worker_id" id="select_worker" onclick="selected()">
            <option selected value="">Choose WorkerID...</option>
            <?php while ($row = mysqli_fetch_array($result1)):; ?>
                <option value="<?php echo $row[0] ?>"><?php echo $row[0] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="container">
        <button type="submit" class="btn btn-secondary" disabled id="button">GET</button>
    </div>
    <script>
        function selected() {
            document.getElementById("button").disabled = false;
        }
    </script>
</form>

<div class="container">
    <canvas id="chart"
            style="width: 70%; height: 35vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
    <script>
        var ctx = document.getElementById("chart").getContext('2d');
        var sum = 0;
        var data1 = [<?php echo $data1; ?>];
        for (var i = 0; i < data1.length; i++) {
            sum += parseInt(data1[i], 10);
        }
        var singleavg = Math.round(sum / data1.length);
        var avg = [];
        for (var j = 0; j < data1.length; j++) {
            avg.push(singleavg);
        }
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $data2?>],
                datasets:
                    [{
                        label: 'Quality',
                        data: data1,
                        backgroundColor: 'transparent',
                        borderColor: 'rgb(255,34,0)',
                        borderWidth: 3
                    },
                        {
                            label: 'Average',
                            data: avg,
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(10,0,255)',
                            borderWidth: 1,
                        }
                    ]
            },
            options: {
                scales: {scales: {yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                tooltips: {mode: 'index'},
                legend: {display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
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
        <a href="#" class="previous round">&#8249;</a>

        <button style="font-size:16px" onclick="window.location.href='/Chart'" class="btn btn-secondary">Dashboard <i
                    class="fa fa-dashboard"></i>
        </button>

        <a href="#" class="next round">&#8250;</a>

    </div>
</div>

</body>
</html>