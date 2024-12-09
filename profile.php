<?php
session_start(); // Start the session

// Check if user is an admin
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM user_details WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<div class='alert'>Record deleted successfully</div>";
    } else {
        echo "<div class='alert'>Error deleting record: " . $conn->error . "</div>";
    }
}

// Fetch user details
$sql = "SELECT * FROM user_details";
$result = $conn->query($sql);

// Fetch count of users
$user_count_sql = "SELECT COUNT(*) AS total_users, SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) AS normal_users, SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) AS admin_users FROM users";
$user_count_result = $conn->query($user_count_sql);
$user_counts = $user_count_result->fetch_assoc();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profiles</title>
    <link rel="stylesheet" href="pro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100vh;
            background-color: black;
            font-family: Arial, sans-serif;
            color: white;
        }

        #main-container {
            height: 97vh;
            width: 100%;
            overflow-y: auto;
            padding: 20px;
        }

        #user-summary {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #333;
        }

        .user-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            background-color: #444;
        }

        .user-card p {
            margin: 5px 0;
            color: #ccc;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
        }

        header {
            padding: 10px;
            background-color: #222;
        }

        #container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header {
            text-decoration: none;
            margin-inline: 20px;
            color: #ffffff;
            margin-top: 25px;
            font-weight: 500;
            font-size: 20px;
        }

        .header:hover {
            background-image: linear-gradient(135deg, #FFDB01 10%, #0E197D 100%);
            -webkit-background-clip: text;
            color: transparent;
            transition: 0.5s;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {
            .user-card {
                margin: 10px 5%;
            }
        }
    </style>
</head>

<body>
    <header>
        <div id="container">
            <a class="header" href="Home.php">Home</a>

            <!-- Show About, Contact, and Upload Details only if not an admin -->
            <?php if (!$is_admin): ?>
                <a class="header" href="about.html">About</a>
                <a class="header" href="contact.php">Contact</a>
                <a class="header" href="details.php">Upload Details</a>
            <?php endif; ?>

            <a class="header" href="technology.html">Profile</a>
            <a class="header" href="profile.php">All Users</a>

            <!-- Show login/logout based on session -->
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="loginpage.php"><button id="login">Login</button></a>
            <?php else: ?>
                <a href="logout.php" id="logout" class="header">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <div id="main-container">
        <h1>User Profiles</h1>

        <div id="user-summary">
            <h2>User Summary</h2>
            <p>Total Users: <?= $user_counts['total_users'] ?></p>
            <p>Normal Users: <?= $user_counts['normal_users'] ?></p>
            <p>Admin Users: <?= $user_counts['admin_users'] ?></p>
        </div>

        <?php
        // Reopen connection to fetch user details
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT * FROM user_details");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='user-card'>
                        <h3>{$row['name']}</h3>
                        <p><strong>Job Type:</strong> {$row['job_type']}</p>
                        <p><strong>Comments:</strong> {$row['comments']}</p>
                        <p><strong>Company:</strong> {$row['company_name']}</p>
                        <p><strong>Location:</strong> {$row['city']}, {$row['country']}</p>";

                echo "<p><strong>Password:</strong> <em>Stored securely (hashed)</em></p>";
                
                // Action Section for Admin
                if ($is_admin) {
                    echo "<div style='margin-top: 10px;'>
                            <a href='edit.php?id={$row['id']}' class='text-blue-500'>Edit</a>
                            <a href='user_details.php?delete_id={$row['id']}' style='color: red;'>Delete</a>
                          </div>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No user profiles found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>
