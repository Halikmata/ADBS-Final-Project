<?php
include_once("db.php");
include_once("updates.php");

$db = new Database();
$connection = $db->getConnection();
$updates = new Updates($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updates on convo</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('header.html'); ?>
    <?php include('navbar.php'); ?>

    <div class="content">
    <h2>Conversations log</h2>
    <a class="button-link" href="updates_add.php">New update</a>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>ID</th>
                <th>Conversation Updated</th>
                <th>Updated By</th>
                <th>Updated On</th>
                <th>Updates Implemented</th>
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
            $results = $updates->displayPage($startIndex, $resultsPerPage);
            foreach ($results as $result) {
            ?>
            <tr>
                
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['conversation_id']; ?></td>
                <td><?php echo $result['updated_by']; ?></td>
                <td><?php echo $result['updated_on']; ?></td>
                <td><?php echo $result['updates_implemented']; ?></td>
                <td>
                    <a href="updates_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="updates_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } 
            // Display pagination links
            $totalRows = $updates->countAll();

            $totalPages = ceil($totalRows / $resultsPerPage);

            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        ?>
        

           
        </tbody>
    </table>
        

        </div>
    <p></p>
</body>
<?php include('footer.html'); ?>
</html>