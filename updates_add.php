<?php
include_once("db.php"); // Include the Database class file
include_once("updates.php"); // Include the Student class file


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'conversation_id' => $_POST['conversation_id'],
    'updated_by' => $_POST['updated_by'],
    'updates_implemented' => $_POST['updates_implemented'],
    ];

    // Instantiate the Database and Trainers classes
    $database = new Database();
    $updates = new Updates($database);
    $updates_id = $updates->create($data);
    echo '<script>
                alert("Record added successfully.");
                window.location.href = "updates.view.php?msg=Record added successfully.";
            </script>';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>New Update</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h1>Record New Conversation Update</h1>
    <a class="button-link" href="updates.view.php">BACK</a>
    <form action="" method="post" class="centered-form">
        <label for="conversation_id">Conversation ID</label>
        <input type="text" name="conversation_id" id="conversation_id" required>

        <label for="updated_by">Updated By</label>
        <input type="text" name="updated_by" id="updated_by" required>

        <label for="updates_implemented">Updates Implemented</label>
        <input type="text" name="updates_implemented" id="updates_implemented" required>

        <input type="submit" value="Add Update">
    </form>
    </div>
    
    <?php include('footer.html'); ?>
</body>
</html>