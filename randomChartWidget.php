<?php
/* Database connection settings */
$host = 'localhost';
$user = 'utente';
$pass = 'pass123';
$db = 'dbmysql';
$mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);
$result1 = '';
$data1 = '';
$data2 = '';
$data3 = '';
$file = '';
if (!empty($_POST['db'])) {
    $db = $_POST['db'];
    if ($db == 'Image') {
        $query1 = "SELECT WORKER_ID, COUNT(DISTINCT SEX) as COUNTSEX, COUNT(DISTINCT AGE) as COUNTAGE FROM `immquality` GROUP BY WORKER_ID ORDER BY COUNTAGE DESC, COUNTSEX";
        $result1 = mysqli_query($mysqli, $query1);
        $file = 'Image';
    } else
        if ($db == 'Video') {
            $query2 = "SELECT WORKER_ID, COUNT(DISTINCT SEX) as COUNTSEX, COUNT(DISTINCT AGE) as COUNTAGE FROM `vidquality` GROUP BY WORKER_ID ORDER BY COUNTAGE DESC, COUNTSEX";
            $result1 = mysqli_query($mysqli, $query2);
            $file = 'Video';
        }
    while ($row = mysqli_fetch_array($result1)) {
        if ($row['COUNTSEX'] > 1 || $row['COUNTAGE'] > 1) {
            $data1 = $data1 . '"' . $row['WORKER_ID'] . '",';
            if ($row['COUNTSEX'] == 1) {
                $data = $row['COUNTAGE'];
            } else if ($row['COUNTAGE'] == 1) {
                $data = $row['COUNTSEX'];
            } else {
                $data = $row['COUNTSEX'] + $row['COUNTAGE'];
            }
            $data2 = $data2 . '"' . $data . '",';
        }
    }
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
    <h1>LIAR WORKERS</h1>
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
<div class="container">
    <canvas id="chart"
            style="width: 95%; height: 63vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
    <script>
        var ctx = document.getElementById("chart").getContext('2d');
        var data1 = [<?php echo $data1; ?>];
        var data2 = [<?php echo $data2; ?>];
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data1,
                datasets:
                    [{
                        label: ["Different value of Age and Sex by Worker"],
                        data: data2,
                        backgroundColor: 'rgba(255,34,0,0.2)',
                        borderColor: 'rgb(255,34,0)',
                        borderWidth: 1,
                    }
                    ]
            },
            options: {
                scales: {scales: {yAxes: [{beginAtZero: true}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                tooltips: {mode: 'index'},
                legend: {display: false},
                title: {
                    display: true,
                    position: 'bottom',
                    text: '<?php echo $file;?>' + ' Top Liar Workers',
                    fontColor: 'rgba(255,249,255,0.5)',
                    fontSize: 16,
                }
            }
        });
    </script>
</div>

</body>
</html>