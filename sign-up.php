<?php
session_start(); // Start the session
require_once 'auth.php'; // Include authentication functions

// Database connection
try {
    $db = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['USERNAME']));
    $password = htmlspecialchars(trim($_POST['password']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = $_POST['role']; // Get the user role from the form

    // Check if the username or email already exists
    $check_user = $db->prepare("SELECT * FROM users WHERE email = ?");
    $check_user->execute([$email]);
    if ($check_user->rowCount() > 0) {
        $error_message = "Email is already registered!";
    } else {
        try {
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $hashed_password);
            $stmt->bindParam(4, $role);

            if ($stmt->execute()) {
                header("Location: loginpage.php");
                exit();
            } else {
                $error_message = "Error creating account.";
            }
        } catch (PDOException $e) {
            $error_message = "Error creating account: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="sign-up.css">
    <!-- <link rel="stylesheet" href="loginpage.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div id="container">
        <div class="signup">
            <h1>Sign Up</h1>

            <!-- Display error message if there is one -->
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <!-- Start of the signup form -->
            <form method="POST" action="">
                <input type="text" name="USERNAME" placeholder="USERNAME" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" minlength="8" required><br>

              <!-- Select Role -->
<label for="role">Select Role:</label><br>
<select name="role" id="role" required>
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select><br>

                <button type="submit">Sign Up</button>
            </form>
            <!-- End of the signup form -->

            <hr id="horizontal">
            <p id="or">Or</p>

            <footer>
                <div id="footer">
                    <p id="paragraph">Already have an account?</p>
                    <nav>
                        <a href="loginpage.php" id="login">Login</a>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
