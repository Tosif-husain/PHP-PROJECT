<?php
session_start(); 
require_once 'auth.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['USERNAME']));
    $password = htmlspecialchars(trim($_POST['password']));

    $user = loginUser($username, $password);
    
    if ($user) {
        $_SESSION['user'] = $user; 
        if ($user['role'] == 'admin') {
            $_SESSION['is_admin'] = true; 
            header("Location: home.php"); 
        } else {
            $_SESSION['is_admin'] = false; 
            header("Location: home.php"); 
        }
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="loginpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="container">
        <div class="login">
            <h1>Login</h1>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="USERNAME" id="name" placeholder="USERNAME" required><br>
                <input type="password" name="password" id="password" placeholder="Password" minlength="8" required><br>

                <input type="checkbox" id="checkbox">
                <label for="checkbox" id="checkbox_text">Remember me</label><br>

                <div id="button">
                    <button class="login_button" type="submit">Login</button><br>
                </div>

                <p id="forget">Forgot password?</p>
            </form>

            <hr id="horizontal">
            <p id="or">Or</p>

            <div id="images">
                <a href="https://www.google.com/">
                    <i class="fa-brands fa-google" style="color: #ffffff;"></i>
                </a>
                <a href="https://www.facebook.com/">
                    <i class="fa-brands fa-facebook" style="color: #14a8cd;"></i>
                </a>
                <a href="https://github.com/">
                    <i class="fa-brands fa-square-github" style="color: #ffffff;"></i>
                </a>
            </div>

            <footer>
                <div id="footer">
                    <p id="paragraph">Don't have an account?</p>
                    <nav>
                        <a href="sign-up.php" id="signup">Sign up</a>
                    </nav>
                </div>

                <div id="last">
                    <a href="#" id="Terms_support_care">Terms & condition</a>
                    <a href="#" id="Terms_support_care">Support</a>
                    <a href="#" id="Terms_support_care">Customer care</a>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
