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
$file = '';
if (!empty($_POST['db'])) {
    $db = $_POST['db'];
    if ($db == 'Image') {
        $query1 = "SELECT RESOLUTION FROM `immquality` GROUP BY WORKER_ID";
        $result1 = mysqli_query($mysqli, $query1);
        $file = 'Image';
    } else
        if ($db == 'Video') {
            $query2 = "SELECT RESOLUTION FROM `vidquality` GROUP BY WORKER_ID";
            $result1 = mysqli_query($mysqli, $query2);
            $file = 'Video';
        }
    while ($row = mysqli_fetch_array($result1)) {
        $data1 = $data1 . '"' . $row['RESOLUTION'] . '",';
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
    <h1>SCREEN RESOLUTION</h1>
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
        var data = ['HD READY', 'FULL HD', '2K', 'SUPER HD', '4K'];
        var count = [];
        for (var i = 0; i < 5; i++) {
            count[i] = 0;
        }
        for (var j = 0; j < data1.length; j++) {
            var split = data1[j].split('x');
            if (split[0] < 1280 && split[1] < 720) {
                count[0] += 1;
            } else if (split[0] < 1920 && split[1] < 1080) {
                count[1] += 1;
            } else if (split[0] < 2048 && split[1] < 1080) {
                count[2] += 1;
            } else if (split[0] < 3840 && split[1] < 2160) {
                count[3] += 1;
            } else if (split[0] < 4096 && split[1] < 2160) {
                count[4] += 1;
            }
        }
        for (var i = 0; i < 5; i++) {
            count[i] = Math.round(count[i] * 100 / data1.length);
        }
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data,
                datasets:
                    [{
                        data: count,
                        backgroundColor: 'rgb(21,255,0,0.2)',
                        borderColor: 'rgb(21,255,0)',
                        borderWidth: 1,
                    }
                    ]
            },
            options: {
                scales: {scales: {yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                tooltips: {mode: 'index'},
                legend: {display: false},
                title: {
                    display: true,
                    position: 'bottom',
                    text: '<?php echo $file;?>' + ' Screen Resolution Percentage',
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
        <a href="sexChart.php" class="previous round">&#8249;</a>

        <button style="font-size:16px" onclick="window.location.href='/Chart'" class="btn btn-secondary">Dashboard <i
                    class="fa fa-dashboard"></i>
        </button>

        <a href="chartFile.php" class="next round">&#8250;</a>

    </div>
</div>

</body>
</html>