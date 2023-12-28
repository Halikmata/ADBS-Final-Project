<?php
session_start();

include_once("db.php");

$db = new Database();
$connection = $db->getConnection();

// Check if the user is already logged in, redirect them to conversations.view.php
if (isset($_SESSION['user_id'])) {
    header("Location: conversations.view.php");
    exit();
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You should validate and sanitize user input before using it in a query to prevent SQL injection

    $query = "SELECT * FROM mydb.users WHERE username = :username AND password = :password";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        header("Location: conversations.view.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

// Handle signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = $_POST['signup_username'];
    $password = $_POST['signup_password'];
    $employeeId = $_POST['employee_id'];

    // You should validate and sanitize user input before using it in a query to prevent SQL injection

    $query = "INSERT INTO mydb.users (username, password, idemployees) 
              VALUES (:username, :password, :employeeId)";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":employeeId", $employeeId);

    if ($stmt->execute()) {
        $signupSuccess = "Account created successfully. You can now log in.";
    } else {
        $signupError = "Error creating account. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations Log</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <style>
        body {
            background-image: url('homepage_bg.jpg');
        }

        h2 {
            text-align: center;
        }

        .content {
            margin: 0 auto; /* Center the content */
            max-width: 800px; /* Optional: Set a maximum width for the content */
            padding: 20px; /* Optional: Add padding for better readability */
        }

        /* Added styles for buttons */
        button {
            padding: 10px;
            margin: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Include the header -->
    <?php include('header.html'); ?>

    <div class="content">
        <h2><strong>SHARED A.I GENERATED SOLUTIONS PLATFORM</strong></h2>

        <!-- Buttons to toggle between forms -->
        <button onclick="showLoginForm()">Login</button>
        <button onclick="showSignupForm()">Sign Up</button>

        <!-- Login Form -->
        <div id="loginForm" style="display: block;">
            <h3>Login</h3>
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <input type="submit" name="login" value="Login">
            </form>

            <?php if (isset($loginError)) { ?>
                <p><?php echo $loginError; ?></p>
            <?php } ?>
        </div>

        <!-- Signup Form -->
        <div id="signupForm" style="display: none;">
            <h3>Signup</h3>
            <form method="post" action="">
                <label for="signup_username">Username:</label>
                <input type="text" name="signup_username" required>

                <label for="signup_password">Password:</label>
                <input type="password" name="signup_password" required>

                <label for="employee_id">Employee ID:</label>
                <input type="text" name="employee_id" required>

                <input type="submit" name="signup" value="Sign Up">
            </form>

            <?php
            if (isset($signupSuccess)) {
                echo "<p>$signupSuccess</p>";
            }

            if (isset($signupError)) {
                echo "<p>$signupError</p>";
            }
            ?>
        </div>
    </div>

    <!-- Include the footer -->
    <?php include('footer.html'); ?>

    <script>
        function showLoginForm() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
        }

        function showSignupForm() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
        }
    </script>
</body>
</html>
