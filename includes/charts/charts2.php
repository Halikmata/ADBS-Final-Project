<?php
include_once("../../db.php");
include_once("../../conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);

// Fetch data from the database
$sql = "SELECT ai_used, COUNT(id) as conversationCount FROM ai_conversations GROUP BY ai_used";
$stmt = $connection->prepare($sql);
$stmt->execute();
$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Transform the data for chart rendering
$dataPoints = array();
foreach ($resultSet as $row) {
    $aiUsedLabel = getAiUsedLabel($row['ai_used']); // Assuming you have a function to get labels
    $dataPoints[] = array("label" => $aiUsedLabel, "y" => (float)$row['conversationCount']);
}

function getAiUsedLabel($aiUsedValue) {
    switch ($aiUsedValue) {
        case 1:
            return "ChatGPT";
        case 2:
            return "Bard";
        case 3:
            return "You";
        case 4:
            return "Bing AI";
        default:
            return "Unknown";
    }
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
        <h2>Distribution of Conversations across AI</h2>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

        <!-- JavaScript code with modified dataPoints with assistance from chatGPT -->
        <script>
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "A.I Preference"
                    },
                    axisY: {
                        suffix: "",
                        scaleBreaks: {
                            autoCalculate: true
                        }
                    },
                    data: [{
                        type: "column",
                        yValueFormatString: "#,##0\"\"",
                        indexLabel: "{y}",
                        indexLabelPlacement: "inside",
                        indexLabelFontColor: "white",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
            }
        </script>
    </div>
</body>
</html>