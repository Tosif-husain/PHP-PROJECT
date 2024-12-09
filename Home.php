<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <div id="container">
            <a class="header" href="Home.php">Home</a>

            <?php if (isset($_SESSION['user']) && (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin')): ?>
                <a class="header" href="about.html">About</a>
                <a class="header" href="details.php">Upload Details</a>
            <?php endif; ?>

            <?php
            if (isset($_SESSION['user'])) {
                if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                    echo '<a class="header" href="display_contact.php">Feedback</a>';
                } else {
                    echo '<a class="header" href="contact.php">Contact</a>'; 
                }
            }
            ?>

            <a class="header" href="technology.html">Profile</a>
            <a class="header" href="profile.php">All User</a>

            <?php if (!isset($_SESSION['user'])):  ?>
                <a href="loginpage.php" class="header" id="login">Login</a>
            <?php else:  ?>
                <a href="logout.php" class="header" id="logout">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <div id="main-container">
        <div id="child-container">
            <h2>Organize your files and keep them safe, everywhere!</h2>
            <p>
                We offer secure storage, ensuring all your data is protected from unauthorized access.
            </p>
            <button class="get-started">Get Started</button>

            <p id="request-a-demo">Request a demo</p>

            <div id="div-footer">
                <div id="one">
                    <span class="material-symbols-outlined">group</span>
                    <h3 class="user">1M+</h3>
                    <p class="paragraph">Active users</p>
                </div>
                <div id="folder">
                    <span class="material-symbols-outlined">folder</span>
                    <h3 class="tb">5TB+</h3>
                    <p class="files-stored">Files stored</p>
                </div>
                <div id="file">
                    <span class="material-symbols-outlined">upload_file</span>
                    <h3 id="upload_file">6M+</h3>
                    <p class="upload_file">Uploaded files</p>
                </div>
            </div>
        </div>

        <div id="second-child">
            <img src="images/folder.png" alt="Folder Image" />
        </div>
    </div>
</body>
</html>
