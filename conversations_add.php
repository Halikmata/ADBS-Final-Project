<?php
include_once("db.php"); // Include the Database class file
include_once("conversations.php"); // Include the Student class file


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'ai_used' => $_POST['ai_used'],
    'conversation_name' => $_POST['conversation_name'],
    'access_level' => $_POST['access_level'],
    'created_by' => $_POST['created_by'],
    'description' => $_POST['description'],
    ];

    // Instantiate the Database and Trainers classes
    $database = new Database();
    $conversations = new Conversations($database);
    $conversations_id = $conversations->create($data);
    echo '<script>
                alert("Record added successfully.");
                window.location.href = "conversations.view.php?msg=Record added successfully.";
            </script>';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title>Add New Thread</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h1>Add conversation details</h1>
    <form action="" method="post" class="centered-form">
        <label for="ai_used">ID of A.I used:</label>
        <input type="text" name="ai_used" id="ai_used" required>

        <label for="conversation_name">Conversation/thread name:</label>
        <input type="text" name="conversation_name" id="conversation" required>

        <label for="access_level">Access level:</label>
        <input type="text" name="access_level" id="access_level" required>

        <label for="created_by">Creator's employee ID:</label>
        <input type="text" name="created_by" id="created_by" required>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description" required>

        <input type="submit" value="Add to records">
    </form>
    </div>
    
    <?php include('footer.html'); ?>
</body>
</html>
