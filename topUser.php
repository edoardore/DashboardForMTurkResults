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
        $query1 = "SELECT WORKER_ID, COUNT(IMAGE_FILE) AS NUM FROM `immquality` GROUP BY WORKER_ID ORDER BY NUM DESC";
        $result1 = mysqli_query($mysqli, $query1);
        $file = 'Image';
    } else
        if ($db == 'Video') {
            $query2 = "SELECT WORKER_ID, COUNT(VIDEO_FILE) AS NUM FROM `vidquality` GROUP BY WORKER_ID ORDER BY NUM DESC";
            $result1 = mysqli_query($mysqli, $query2);
            $file = 'Video';
        }
    while ($row = mysqli_fetch_array($result1)) {
        $data1 = $data1 . '"' . $row['WORKER_ID'] . '",';
        $data2 = $data2 . '"' . $row['NUM'] . '",';
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
            margin: 80px 100px 10px 100px;
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
    <h1>TOP WORKERS</h1>
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
            style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>
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
                        data: data2,
                        backgroundColor: 'rgb(10,0,255, 0.2)',
                        borderColor: 'rgb(10,0,255)',
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
                    text: '<?php echo $file;?>' + ' Top Workers',
                    fontColor: 'rgba(255,249,255,0.5)',
                    fontSize: 16,
                }
            }
        });
    </script>
    <div class="container">
        <button style="font-size:16px" onclick="window.location.href='/Chart'" class="btn btn-secondary">Dashboard <i
                    class="fa fa-dashboard"></i>
        </button>
    </div>
</div>

</body>
</html>