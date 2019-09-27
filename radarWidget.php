<?php
/* Database connection settings */
$host = 'localhost';
$user = 'utente';
$pass = 'pass123';
$db = 'dbmysql';
$mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);
session_start();
$result1 = '';
$select = '';
if (!empty($_POST['db'])) {
    $db = $_POST['db'];
    if ($db == 'Image') {
        $query1 = "SELECT DISTINCT WORKER_ID FROM `immquality`";
        $result1 = mysqli_query($mysqli, $query1);
        $_SESSION['db'] = 'Image';
        while ($row = mysqli_fetch_array($result1)) {
            $select = $select . '<option>' . $row[0] . '</option>';
        }
    } else
        if ($db == 'Video') {
            $query2 = "SELECT DISTINCT WORKER_ID FROM `vidquality`";
            $result1 = mysqli_query($mysqli, $query2);
            $_SESSION['db'] = 'Video';
            while ($row = mysqli_fetch_array($result1)) {
                $select = $select . '<option>' . $row[0] . '</option>';
            }
        }
}
$data1 = '';
$data2 = '';
if (!empty($_POST['worker_id1']) && !empty($_POST['worker_id2'])) {
    if ($_SESSION['db'] == 'Image') {
        $worker_id1 = $_POST['worker_id1'];
        $sql = "SELECT QUALITY FROM `immquality` WHERE WORKER_ID= '$worker_id1'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
        }
        $data1 = trim($data1, ",");

        $worker_id2 = $_POST['worker_id2'];
        $sql2 = "SELECT QUALITY FROM `immquality` WHERE WORKER_ID= '$worker_id2'";
        $result2 = mysqli_query($mysqli, $sql2);
        while ($row = mysqli_fetch_array($result2)) {
            $data2 = $data2 . '"' . $row['QUALITY'] . '",';
        }
        $data2 = trim($data2, ",");

    } else if ($_SESSION['db'] == 'Video') {
        $worker_id1 = $_POST['worker_id1'];
        $sql = "SELECT QUALITY FROM `vidquality` WHERE WORKER_ID= '$worker_id1'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $data1 = $data1 . '"' . $row['QUALITY'] . '",';
        }
        $data1 = trim($data1, ",");

        $worker_id2 = $_POST['worker_id2'];
        $sql2 = "SELECT QUALITY FROM `vidquality` WHERE WORKER_ID= '$worker_id2'";
        $result2 = mysqli_query($mysqli, $sql2);
        while ($row = mysqli_fetch_array($result2)) {
            $data2 = $data2 . '"' . $row['QUALITY'] . '",';
        }
        $data2 = trim($data2, ",");
    }
} else {
    $data1 = -1;
    $data2 = -1;
    $worker_id1 = 'Worker1';
    $worker_id2 = 'Worker2';
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
    <h1>COMPARED HISTORY OF TWO WORKER</h1>
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
        <select class="custom-select" name="worker_id1" id="select_worker1"">
        <option selected value="">Choose WorkerID...</option>
        <?php echo $select ?>
        </select>
    </div>
    <div class="container">
        <select class="custom-select" name="worker_id2" id="select_worker2" onclick="selected()">
            <option selected value="">Choose WorkerID...</option>
            <?php echo $select ?>
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
            style="width: 60%; height: 25vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
    <script>
        var ctx = document.getElementById("chart").getContext('2d');
        var sum = 0;
        var data1 = [<?php echo $data1; ?>];
        var data2 = [<?php echo $data2?>];
        count = []
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
        count2 = []
        for (var i = 0; i < 5; i++) {
            count2[i] = 0;
        }
        for (var j = 0; j < data2.length; j++) {
            if (data2[j] < 20 && data2[j] >= 0) {
                count2[0] += 1;
            }
            if (data2[j] < 40 && data2[j] >= 20) {
                count2[1] += 1;
            }
            if (data2[j] < 60 && data2[j] >= 40) {
                count2[2] += 1;
            }
            if (data2[j] < 80 && data2[j] >= 60) {
                count2[3] += 1;
            }
            if (data2[j] <= 100 && data2[j] >= 80) {
                count2[4] += 1;
            }
        }
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Bad', 'Poor', 'Fair', 'Good', 'Excellent'],
                datasets:
                    [{
                        label: '<?php echo $worker_id1; ?>',
                        data: count,
                        backgroundColor: 'rgb(255,34,0, 0.2)',
                        borderColor: 'rgb(255,34,0)',
                        pointBackgroundColor: 'rgb(255,34,0)',
                        borderWidth: 3
                    },
                        {
                            label: '<?php  echo $worker_id2; ?>',
                            data: count2,
                            backgroundColor: 'rgb(10,0,255, 0.2)',
                            borderColor: 'rgb(10,0,255)',
                            pointBackgroundColor: 'rgb(10,0,255)',
                            borderWidth: 3,
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
</div>

</body>
</html>