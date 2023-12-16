<?php
include_once("db.php");
include_once("conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations Log</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
    </script>
    <style>
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Include the header -->
    <?php include('header.html'); ?>
    <div class="content">
        <h2><strong>SHARED A.I GENERATED SOLUTIONS PLATFORM</strong></h2>
    </div>
    <?php include('navbar.php'); ?>


<div class="content">
</div>

        <!-- Include the footer -->
    <?php include('footer.html'); ?>
</body>
</html>
