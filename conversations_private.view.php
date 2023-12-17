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
    <title>Conversations</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h2>Confidential</h2>
    <a class="button-link" href="conversations_add.php">Add Convo</a>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Conversation ID</th>
                <th>A.I used</th>
                <th>Label</th>
                <th>Access Level</th>
                <th>Created By:</th>
                <th>Created On:</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $resultsPerPage = 10; // Number of results per page
            
            // Calculate the starting index for the current page
            $startIndex = ($page - 1) * $resultsPerPage;
            
            // Fetch results for the current page
            $results = $conversations->p_displayPage($startIndex, $resultsPerPage);
            foreach ($results as $result) {
            ?>
            <tr>
                
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['ai_used']; ?></td>
                <td><?php echo $result['conversation_name']; ?></td>
                <td><?php echo $result['access_level']; ?></td>
                <td><?php echo $result['created_by']; ?></td>
                <td><?php echo $result['created_on']; ?></td>
                <td><?php echo $result['description']; ?></td>
                <td>
                    <a href="conversations_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="conversations_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } 
            // Display pagination links
            $totalRows = $conversations->countAll();

            $totalPages = ceil($totalRows / $resultsPerPage);

            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        ?>
        

           
        </tbody>
    </table>
        
    <a class="button-link" href="conversations.view.php">BACK</a> <!-- I moved it upwards -->

        </div>
    <p></p>
</body>
<?php include('footer.html'); ?>
</html>