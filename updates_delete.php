<?php
include_once("db.php"); 
include_once("updates.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Instantiate the Database and Student classes
    $db = new Database();
    $updates = new Updates($db);

    // Call the delete method to delete the province record
    if ($updates->delete($id)) {
        // JavaScript code for the pop-up message is from stackoverflow
        echo '<script>
                    alert("Record deleted successfully.");
                    window.location.href = "updates.view.php?msg=Record deleted successfully.";
                </script>';
    
    } else {
        echo "Failed to delete the record.";
    }
    
}
?>
