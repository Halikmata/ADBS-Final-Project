<?php
include_once("db.php");
include_once("conversations.php");

$db = new Database();
$connection = $db->getConnection();
$conversations = new Conversations($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"]; // Get the password entered by the user

    // Check if the password is correct (you may want to replace 'your_password' with the actual password)
    if ($password == 'admin123') {
        // Redirect to the private conversations page
        header("Location: conversations_private.view.php");
        exit();
    } else {
        // Display an error message if the password is incorrect
        $error_message = "Incorrect password. Please try again.";
    }
}
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
        <h2>Our Conversations</h2>
        <a class="button-link" href="conversations_add.php">Add Convo</a>

        <div style="float: right; margin-right: 10px;">
            <li class="dropdown">
                    <a href="#" class="button-link">CHARTS</a>
                    <div class="dropdown-content" style="background-color: #f1f1f1">
                        <a href="includes/charts/charts1.php" target="_blank">1. Charts1</a>
                        <a href="includes/charts/charts2.php" target="_blank">2. Charts2</a>
                        <a href="includes/charts/charts3.php" target="_blank">3. Charts3</a>
                    </div>
                </li>
        </div>

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
                $results = $conversations->displayPage($startIndex, $resultsPerPage);
                foreach ($results as $result) {
                ?>
                <tr>
                    <td><?php echo $result['id']; ?></td>
                    <td><?php echo $result['A.I Used']; ?></td>
                    <td><?php echo $result['Conversation Name']; ?></td>
                    <td><?php echo $result['Access Level']; ?></td>
                    <td><?php echo $result['Created By']; ?></td>
                    <td><?php echo $result['Created On']; ?></td>
                    <td><?php echo $result['Description']; ?></td>
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

        <!-- JavaScript function to toggle password visibility -->
        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("password");
                var visibilityCheckbox = document.getElementById("toggleVisibility");

                if (visibilityCheckbox.checked) {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>

        <!-- Form to enter password -->
        <form method="post" style="background-color: #f1f1f1; padding: 40px; box-shadow: 0 0 0px rgba(0, 0, 0, 0.1); width: 500px; border: none;">
            <!-- <label for="password">Password:</label> -->
            <label for="toggleVisibility" style="color: white">Password:</label>
            <input type="password" id="password" name="password" required>
            <!-- Checkbox to toggle password visibility -->
            <label for="toggleVisibility" style="color: white">
                <input type="checkbox" id="toggleVisibility" onchange="togglePasswordVisibility()">
                Show Password
            </label>
            
            <button type="submit" class="button-link">SUBMIT</button>
        </form>

        <?php
            // Display error message if any
            if (isset($error_message)) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
        ?>
    </div>
    <p></p>
</body>
<?php include('footer.html'); ?>
</html>