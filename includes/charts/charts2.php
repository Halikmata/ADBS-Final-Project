<?php
include_once("../../db.php");
include_once("../../conversations.php");
$database = new Database();
$connection = $database->getConnection();


// Query to get the count of female students
$query = "SELECT count(id) as Open FROM mydb.access_level WHERE id = 1";
// $result = mysqli_query($connection, $query);

try {
    $result = $connection->query($query);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $open1 = (int)$row['Open'];
    } else {
        $open1 = 0;
    }
} catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
}

// Query to get the count of female students
$query = "SELECT count(id) as Restricted FROM mydb.access_level WHERE id = 2";

try {
    $result = $connection->query($query);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $restricted1 = (int)$row['Restricted'];
    } else {
        $restricted1 = 0;
    }
} catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
}

// Query to get the count of female students
$query = "SELECT count(id) as Confidential FROM mydb.access_level WHERE id = 3";

try {
    $result = $connection->query($query);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $confidential1 = (int)$row['Confidential'];
    } else {
        $confidential1 = 0;
    }
} catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
}



$totalConvo = $open1 + $restricted1 + $confidential1;

// Data points for the chart
$convoDataPoints = array(
    array("y"=> $open1, "name"=> "Open", "color"=> "#3D5A80"),
    array("y"=> $restricted1, "name"=> "Restricted", "color"=> "#98C1D9"),
    array("y"=> $confidential1, "name"=> "Confidential", "color"=> "#98C1D2")
);
?>
<!DOCTYPE HTML>
<html>
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 1</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include('../../header.html'); ?>
    <?php include('../../navbar.php'); ?>

    <script>
        window.onload = function () {
        
        var totalConvo = <?php echo $totalConvo ?>;
        var studentsData = {
            "Ratio of Access Level": [{
                click: studentsChartDrilldownHandler,
                cursor: "pointer",
                explodeOnClick: false,
                innerRadius: "75%",
                legendMarkerType: "square",
                name: "Ratio of Access Level",
                radius: "100%",
                showInLegend: true,
                startAngle: 90,
                type: "doughnut",
                dataPoints: <?php echo json_encode($genderDataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        };
        
        var studentsOptions = {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Ratio of Access Level"
            },
            subtitles: [{
                text: "",
                backgroundColor: "#2eacd1",
                fontSize: 16,
                fontColor: "white",
                padding: 5
            }],
            legend: {
                fontFamily: "calibri",
                fontSize: 14,
                itemTextFormatter: function (e) {
                    return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalConvo * 100) + "%";  
                }
            },
            data: []
        };


        var chart = new CanvasJS.Chart("chartContainer", studentsOptions);
        chart.options.data = studentsData["Ratio of Access Level"];
        chart.render();
        
        function studentsChartDrilldownHandler(e) {
            chart = new CanvasJS.Chart("chartContainer", studentsOptions);
            chart.options.data = studentsData[e.dataPoint.name];
            chart.options.title = { text: e.dataPoint.name }
            chart.render();
            $("#backButton").toggleClass("invisible");
        }
        
        $("#backButton").click(function() { 
            $(this).toggleClass("invisible");
            chart = new CanvasJS.Chart("chartContainer", studentsOptions);
            chart.options.data = studentsData["Ratio of Access Level"];
            chart.render();
        });
        
        }
    </script>

    <div id="chartContainer" style="height: 370px; width: 77%;"></div>
    <button class="btn invisible" id="backButton">&lt; Back</button>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
