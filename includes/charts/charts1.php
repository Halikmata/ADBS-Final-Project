<?php
include_once("../../db.php");
include_once("../../conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);
// start here Mav

$dataPoints = array(
	array("label"=> "Food + Drinks", "y"=> 590),
	array("label"=> "Activities and Entertainments", "y"=> 261),
	array("label"=> "Health and Fitness", "y"=> 158),
	array("label"=> "Shopping & Misc", "y"=> 72),
	array("label"=> "Transportation", "y"=> 191),
	array("label"=> "Rent", "y"=> 573),
	array("label"=> "Travel Insurance", "y"=> 126)
);


//End here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations Log</title>
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
    </script>
    <style>
        h2 {
            text-align: center;
        }
    </style>
    <!-- start here -->
    <script>
    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: "Average Expense Per Day  in Thai Baht"
        },
        subtitles: [{
            text: "Currency Used: Thai Baht (฿)"
        }],
        data: [{
            type: "pie",
            showInLegend: "true",
            legendText: "{label}",
            indexLabelFontSize: 16,
            indexLabel: "{label} - #percent%",
            yValueFormatString: "฿#,##0",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
    
    }
    </script>
    <!-- end here -->
</head>
<body>
    <!-- Include the header -->
    <!-- <?php include('../../header.html'); ?> -->
    <div class="content">
        <!-- start here -->
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <!-- end here -->
    </div>



<div class="content">
</div>

        <!-- Include the footer -->
    <!-- <?php include('../../footer.html'); ?> -->
</body>
</html>