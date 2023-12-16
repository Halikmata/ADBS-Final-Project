<?php
include_once("db.php");
include_once("updates.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch Province data by ID from the database
    $db = new Database();
    $updates = new Updates($db);
    $updates_Data = $updates->read($id); 

   
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'conversation_id' => $_POST['conversation_id'],
        'updated_by' => $_POST['updated_by'],
        'updated_on' => $_POST['updated_on'], // Use the date function to get the current date and time
        'updates_implemented' => $_POST['updates_implemented'],
    ];


    $db = new Database();
    $updates = new Updates($db);

    // Call the edit method to update the province data
    if ($updates->update($id, $data)) {
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record updated.");
                window.location.href = "updates.view.php?msg=Record updated.";
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
    <title>Edit Update Records</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h2>Edit Update Details</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $updates_Data['id']; ?>">
        
        
        <label for="conversation_id">Conversation ID</label>
        <input type="text" name="conversation_id" id="conversation_id" value="<?php echo $updates_Data['conversation_id']; ?>">
        
        <label for="updated_by">Updated By</label>
        <input type="text" name="updated_by" id="updated_by" value="<?php echo $updates_Data['updated_by']; ?>">

        <label for="updated_on">Updated On</label>
        <input type="text" name="updated_on" id="updated_on" value="<?php echo $updates_Data['updated_on']; ?>">
        
        <label for="updates_implemented">Updates Implemented</label>
        <input type="text" name="updates_implemented" id="updates_implemented" value="<?php echo $updates_Data['updates_implemented']; ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>