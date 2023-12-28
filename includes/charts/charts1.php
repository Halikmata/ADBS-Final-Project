<?php
include_once("../../db.php");
include_once("../../conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);

// Fetch data from the database
$sql = "SELECT created_by, COUNT(id) as contributionCount FROM ai_conversations GROUP BY created_by";
$stmt = $connection->prepare($sql);
$stmt->execute();
$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Transform the data for chart rendering
$dataPoints = array();
foreach ($resultSet as $row) {
    $dataPoints[] = array("label" => "Employee ID " . $row['created_by'], "y" => (int)$row['contributionCount']);
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
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <style>
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Contributions made to the Conversations Table</h1>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

        <script>
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    title:{
                        text: "Employee Contributors"
                    },
                    data: [{
                        type: "pie",
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabelFontSize: 16,
                        indexLabel: "{label} - #percent%",
                        yValueFormatString: "#",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            }
        </script>
    </div>
</body>
</html>