<?php
include_once("db.php");
include_once("conversations.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch Province data by ID from the database
    $db = new Database();
    $conversations = new Conversations($db);
    $conversations_Data = $conversations->read($id); 

   
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'ai_used' => $_POST['ai_used'],
        'conversation_name' => $_POST['conversation_name'],
        'access_level' => $_POST['access_level'],
        'created_by' => $_POST['created_by'],
        'created_on' => $_POST['created_on'], // Use the date function to get the current date and time
        'description' => $_POST['description'],
    ];


    $db = new Database();
    $conversations = new Conversations($db);

    // Call the edit method to update the province data
    if ($conversations->update($id, $data)) {
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record updated.");
                window.location.href = "conversations.view.php?msg=Record updated.";
              </script>';
    } else {
        echo "Failed to update the record.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Edit Records</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h2>Edit Conversation Details</h2>
    <a class="button-link" href="conversations.view.php">BACK</a>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $conversations_Data['id']; ?>">
        
        
        <label for="ai_used">ID of A.I used:</label>
        <input type="text" name="ai_used" id="ai_used" value="<?php echo $conversations_Data['ai_used']; ?>">

        <label for="conversation_name">Conversation/thread name:</label>
        <input type="text" name="conversation_name" id="conversation_name" value="<?php echo $conversations_Data['conversation_name']; ?>">

        <label for="access_level">Access level:</label>
        <input type="text" name="access_level" id="access_level" value="<?php echo $conversations_Data['access_level']; ?>">
        
        <label for="created_by">Creator's employee ID:</label>
        <input type="text" name="created_by" id="created_by" value="<?php echo $conversations_Data['created_by']; ?>">

        <label for="created_on">Created on:</label>
        <input type="text" name="created_on" id="created_on" value="<?php echo $conversations_Data['created_on']; ?>">
        
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="<?php echo $conversations_Data['description']; ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
</body>
<?php include('footer.html'); ?>
</html>