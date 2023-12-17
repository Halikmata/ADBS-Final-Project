<?php
include_once("../../db.php");
include_once("../../student.php");
$database = new Database();
$connection = $database->getConnection();

// Query to get the number of students on the first 10 provinces
$query = "SELECT p.name AS Province, COUNT(s.id) AS 'Number of Students'
          FROM students s
          JOIN student_details sd ON s.id = sd.student_id
          JOIN province p ON sd.province = p.id
          WHERE p.id <= 10
          GROUP BY p.name";

try {
    $result = $connection->query($query);

    $data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = array("label" => $row['Province'], "y" => $row['Number of Students']);
    }
} catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
}

?>
<!DOCTYPE HTML>
<html>
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 3</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
</head>
<body>
    <?php include('../../templates/header.html'); ?>
    <?php include('../navbar.php'); ?>

    <script>
        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title:{
                text: "Number of Students Per Province"
            },
            subtitles: [{
                text: "First 10 provinces"
            }],
            data: [{
                type: "pie",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - #percent%",
                yValueFormatString: "#",
                dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        }
    </script>
    <div id="chartContainer" style="height: 370px;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
