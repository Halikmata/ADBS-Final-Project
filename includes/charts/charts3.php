<?php
include_once("../../db.php");
include_once("../../conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);

// Queries to get the counts
$confidentialCountQuery = "SELECT COUNT(id) as Confidential FROM mydb.ai_conversations WHERE access_level = 3";
$restrictedCountQuery = "SELECT COUNT(id) as Restricted FROM mydb.ai_conversations WHERE access_level = 2";
$openCountQuery = "SELECT COUNT(id) as Open FROM mydb.ai_conversations WHERE access_level = 1";

$confidentialCountResult = $connection->query($confidentialCountQuery);
$restrictedCountResult = $connection->query($restrictedCountQuery);
$openCountResult = $connection->query($openCountQuery);

$confidentialCount = 0;
$restrictedCount = 0;
$openCount = 0;

// Fetching the results using PDO
if ($confidentialCountResult) {
    $confidentialCountRow = $confidentialCountResult->fetch(PDO::FETCH_ASSOC);
    $confidentialCount = ($confidentialCountRow) ? $confidentialCountRow['Confidential'] : 0;
}

if ($restrictedCountResult) {
    $restrictedCountRow = $restrictedCountResult->fetch(PDO::FETCH_ASSOC);
    $restrictedCount = ($restrictedCountRow) ? $restrictedCountRow['Restricted'] : 0;
}

if ($openCountResult) {
    $openCountRow = $openCountResult->fetch(PDO::FETCH_ASSOC);
    $openCount = ($openCountRow) ? $openCountRow['Open'] : 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations Log</title>
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <style>
        h2 {
            text-align: center;
        }
    </style>
    <script>
        window.onload = function () {
            var totalConversations = <?php echo $confidentialCount + $restrictedCount + $openCount; ?>;
            var conversationsData = {
                "Access Levels": [{
                    click: conversationsChartDrilldownHandler,
                    cursor: "pointer",
                    explodeOnClick: false,
                    innerRadius: "75%",
                    legendMarkerType: "square",
                    name: "Access Levels",
                    radius: "100%",
                    showInLegend: true,
                    startAngle: 90,
                    type: "doughnut",
                    dataPoints: [
                        {"y": <?php echo $confidentialCount; ?>, "name": "Confidential", "color": "#E7823A"},
                        {"y": <?php echo $restrictedCount; ?>, "name": "Restricted", "color": "#546BC1"},
                        {"y": <?php echo $openCount; ?>, "name": "Open", "color": "#2eacd1"}
                    ]
                }],
                "Confidential": [{
                    color: "#E7823A",
                    name: "Confidential",
                    type: "column",
                    dataPoints: <?php echo json_encode([["x"=> 0, "y"=> $confidentialCount]]); ?>
                }],
                "Restricted": [{
                    color: "#546BC1",
                    name: "Restricted",
                    type: "column",
                    dataPoints: <?php echo json_encode([["x"=> 1, "y"=> $restrictedCount]]); ?>
                }],
                "Open": [{
                    color: "#2eacd1",
                    name: "Open",
                    type: "column",
                    dataPoints: <?php echo json_encode([["x"=> 2, "y"=> $openCount]]); ?>
                }]
            };

            var conversationsOptions = {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Conversations by Access Levels"
                },
                subtitles: [{
                    text: "Click on Any Segment to Drilldown",
                    backgroundColor: "#2eacd1",
                    fontSize: 16,
                    fontColor: "white",
                    padding: 5
                }],
                legend: {
                    fontFamily: "calibri",
                    fontSize: 14,
                    itemTextFormatter: function (e) {
                        return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalConversations * 100) + "%";
                    }
                },
                data: []
            };

            var conversationsDrilldownedChartOptions = {
                animationEnabled: true,
                theme: "light2",
                axisX: {
                    labelFontColor: "#717171",
                    lineColor: "#a2a2a2",
                    tickColor: "#a2a2a2"
                },
                axisY: {
                    gridThickness: 0,
                    includeZero: false,
                    labelFontColor: "#717171",
                    lineColor: "#a2a2a2",
                    tickColor: "#a2a2a2",
                    lineThickness: 1
                },
                data: []
            };

            var chart = new CanvasJS.Chart("chartContainer", conversationsOptions);
            chart.options.data = conversationsData["Access Levels"];
            chart.render();

            function conversationsChartDrilldownHandler(e) {
                chart = new CanvasJS.Chart("chartContainer", conversationsDrilldownedChartOptions);
                chart.options.data = conversationsData[e.dataPoint.name];
                chart.options.title = { text: e.dataPoint.name }
                chart.render();
                $("#backButton").toggleClass("invisible");
            }

            $("#backButton").click(function() {
                $(this).toggleClass("invisible");
                chart = new CanvasJS.Chart("chartContainer", conversationsOptions);
                chart.options.data = conversationsData["Access Levels"];
                chart.render();
            });
        }
    </script>
    <style>
        #backButton {
            border-radius: 4px;
            padding: 8px;
            border: none;
            font-size: 16px;
            background-color: #2eacd1;
            color: white;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .invisible {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Include the header -->
    <?php include('../../header.html'); ?>
    <div class="content">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <button class="btn invisible" id="backButton">&lt; Back</button>
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    </div>
    <?php include('../../navbar.php'); ?>
    <div class="content"></div>
    <!-- Include the footer -->
    <?php include('../../footer.html'); ?>
</body>
</html>