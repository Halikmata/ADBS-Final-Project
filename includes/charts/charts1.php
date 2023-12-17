<?php
include_once("../../db.php");
include_once("../../conversations.php");
$database = new Database();
$connection = $database->getConnection();

// Query to get the count of female students from North Felicity
$queryFemaleNorthFelicity = "SELECT COUNT(s.id) AS 'female_students_from_North_Felicity'
    FROM students s
    JOIN student_details sd ON s.id = sd.student_id
    JOIN province p ON sd.province = p.id
    WHERE s.gender = 1 AND p.name = 'North Felicity'";

// Query to get the count of male students from North Felicity
$queryMaleNorthFelicity = "SELECT COUNT(s.id) AS 'male_students_from_North_Felicity'
    FROM students s
    JOIN student_details sd ON s.id = sd.student_id
    JOIN province p ON sd.province = p.id
    WHERE s.gender = 0 AND p.name = 'North Felicity'";

// Query to get the count of female students from Destiniland
$queryFemaleDestiniland = "SELECT COUNT(s.id) AS 'female_students_from_Destiniland'
    FROM students s
    JOIN student_details sd ON s.id = sd.student_id
    JOIN province p ON sd.province = p.id
    WHERE s.gender = 1 AND p.name = 'Destiniland'";

// Query to get the count of male students from Destiniland
$queryMaleDestiniland = "SELECT COUNT(s.id) AS 'male_students_from_Destiniland'
    FROM students s
    JOIN student_details sd ON s.id = sd.student_id
    JOIN province p ON sd.province = p.id
    WHERE s.gender = 0 AND p.name = 'Destiniland'";

try {
    // Execute queries
    $resultFemaleNorthFelicity = $connection->query($queryFemaleNorthFelicity);
    $resultMaleNorthFelicity = $connection->query($queryMaleNorthFelicity);
    $resultFemaleDestiniland = $connection->query($queryFemaleDestiniland);
    $resultMaleDestiniland = $connection->query($queryMaleDestiniland);

    // Fetch counts
    $femaleNorthFelicityCount = ($resultFemaleNorthFelicity) ? (int)$resultFemaleNorthFelicity->fetchColumn() : 0;
    $maleNorthFelicityCount = ($resultMaleNorthFelicity) ? (int)$resultMaleNorthFelicity->fetchColumn() : 0;
    $femaleDestinilandCount = ($resultFemaleDestiniland) ? (int)$resultFemaleDestiniland->fetchColumn() : 0;
    $maleDestinilandCount = ($resultMaleDestiniland) ? (int)$resultMaleDestiniland->fetchColumn() : 0;

} catch (PDOException $e) {
    // Handle PDO exception, e.g., log or display an error message
    die("Error executing query: " . $e->getMessage());
}

// Data points for the chart
$genderDataPoints = array(
    array("label"=> "Females from North Felicity", "y"=> $femaleNorthFelicityCount),
    array("label"=> "Males from North Felicity", "y"=> $maleNorthFelicityCount),
    array("label"=> "Females from Destiniland", "y"=> $femaleDestinilandCount),
    array("label"=> "Males from Destiniland", "y"=> $maleDestinilandCount),
);
?>
<!DOCTYPE HTML>
<html>
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report 2</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
</head>
<body>
    <?php include('../../templates/header.html'); ?>
    <?php include('../navbar.php'); ?>

    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Comparison of Male and Female Students"
                },
                axisY:{
                    includeZero: true
                },
                legend:{
                    cursor: "pointer",
                    verticalAlign: "center",
                    horizontalAlign: "right",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    name: "Male and Female Students",
                    indexLabel: "{y}",
                    yValueFormatString: "#0",
                    showInLegend: false,
                    dataPoints: <?php echo json_encode($genderDataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
            
            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    </script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>