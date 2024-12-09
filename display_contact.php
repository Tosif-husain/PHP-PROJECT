<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php'); // Redirect to login page if not an admin
    exit;
}

// Database connection details
$host = 'localhost';
$dbname = 'project';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query
    $stmt = $pdo->query('SELECT full_name, location, message FROM contacts'); // Adjust table name as needed
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Details</title>
    
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        
        body {
            background-color: black;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }
        
        header {
            padding: 30px;
            background-color: #201d1d;
        }
        
        #container {
            display: flex;
            justify-content: center;
        }
        
        div a {
            text-decoration: none;
            margin-inline: 40px;
            color: #ffffff;
            font-family: monospace;
            font-size: large;
        }
        
        div a:hover {
            background-image: linear-gradient(135deg, #FAB2FF 10%, #1904E5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: 0.5s;
        }

        #main-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .contact-card {
            background-color: #333;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .contact-card h2 {
            margin: 0;
            font-size: 1.5em;
        }
        
        .contact-card p {
            margin: 5px 0;
        }
        
        .contact-card .location {
            font-style: italic;
            color: #ccc;
        }
    </style>
</head>
<body>
    <header>
        <div id="container">
            <a href="Home.php" class="header">Home</a>
            <a href="#" class="header">Services</a>
            <a href="#" class="header">Skill</a>
            <a href="#" class="header">Projects</a>
            <a href="display_contact.php" class="header">Contact</a>
        </div>
    </header>

    <div id="main-container">
        <h1 style="text-align: center; margin-top: 20px;">Submitted Contact Details</h1>
        <?php if (count($contacts) > 0): ?>
            <div id="child-container">
                <?php foreach ($contacts as $contact): ?>
                    <div class="contact-card">
                        <h2><?php echo htmlspecialchars($contact['full_name']); ?></h2>
                        <p class="location">Location: <?php echo htmlspecialchars($contact['location']); ?></p>
                        <p>Message: <?php echo nl2br(htmlspecialchars($contact['message'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center;">No contact details available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
