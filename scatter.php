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
        $query1 = "SELECT WORKER_ID, COUNT(IMAGE_FILE) AS NUM, AVG(QUALITY) AS AVERAGE FROM `immquality` GROUP BY WORKER_ID ORDER BY NUM DESC";
        $result1 = mysqli_query($mysqli, $query1);
        $file = 'Image';
    } else
        if ($db == 'Video') {
            $query2 = "SELECT WORKER_ID, COUNT(VIDEO_FILE) AS NUM, AVG(QUALITY) AS AVERAGE FROM `vidquality` GROUP BY WORKER_ID ORDER BY NUM DESC";
            $result1 = mysqli_query($mysqli, $query2);
            $file = 'Video';
        }
    while ($row = mysqli_fetch_array($result1)) {
        $data1 = $data1 . '"' . $row['WORKER_ID'] . '",';
        $data2 = $data2 . '"' . $row['NUM'] . '",';
        $data3 = $data3 . '"' . $row['AVERAGE'] . '",';
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
    <h1>TOP WORKERS AND AVERAGE EVALUATION</h1>
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
        var data3 = [<?php echo $data3; ?>];
        var storage = [];
        for (var i = 0; i < data2.length; i++) {
            x = data2[i];
            y = data3[i];
            var json = {x: x, y: y};
            storage.push(json);
        }
        var myChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                labels: data1,
                datasets: [{
                    data: storage,
                    backgroundColor: 'rgb(10,0,255)',
                    borderColor: 'rgb(10,0,255)',
                    borderWidth: 5,
                }
                ]
            },
            options: {
                scales: {scales: {yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                legend: {display: false},
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'X: <?php echo $file;?> evaluated by Worker, Y: average of quality by Worker',
                    fontColor: 'rgba(255,249,255,0.5)',
                    fontSize: 16,
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.labels[tooltipItem.index];
                            return label + ': (' + tooltipItem.xLabel + ', ' + tooltipItem.yLabel + ')';
                        }
                    }
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
        <a href="topUser.php" class="previous round">&#8249;</a>

        <button style="font-size:16px" onclick="window.location.href='/Chart'" class="btn btn-secondary">Dashboard <i
                    class="fa fa-dashboard"></i>
        </button>
        <a href="randomChart.php" class="next round">&#8250;</a>
    </div>
</div>

</body>
</html>